<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Throwable;

class CategoryController extends Controller
{

    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $categories = $this->categoryRepository->all();
            return view('admin.category.index', compact('categories'));
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to load categories.']);
        }
    }

    public function create()
    {
        try {
            $mainCategories = $this->categoryRepository->all()->whereNull('parent_id');
            return view('admin.category.create', compact('mainCategories'));
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to load form.']);
        }
    }

    public function store(Request $request)
    {
       try {
            $data = $request->validate([
                'title' => 'required|string',
                'parent_id' => 'nullable|exists:categories,id',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string',
                'meta_keyword' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'thumbnail' => 'nullable|image',
            ]);

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('categories', 'public');
            }

            $this->categoryRepository->create($data);

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to create category.'])->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = $this->categoryRepository->find($id);

            $mainCategories = $this->categoryRepository->all()
                ->whereNull('parent_id')
                ->where('id', '!=', $category->id);

            return view('admin.category.edit', compact('category', 'mainCategories'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('categories.index')->withErrors(['error' => 'Category not found.']);
        } catch (Throwable $e) {
            return redirect()->route('categories.index')->withErrors(['error' => 'Failed to load edit form.']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = $this->categoryRepository->find($id);

            $data = $request->validate([
                'title' => 'required|string',
                'parent_id' => 'nullable|exists:categories,id',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string',
                'meta_keyword' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'thumbnail' => 'nullable|image',
            ]);

            if ($request->hasFile('thumbnail')) {
                if ($category->thumbnail && Storage::disk('public')->exists($category->thumbnail)) {
                    Storage::disk('public')->delete($category->thumbnail);
                }

                $data['thumbnail'] = $request->file('thumbnail')->store('categories', 'public');
            } else {
                $data['thumbnail'] = $category->thumbnail;
            }

            $this->categoryRepository->update($id, $data);

            return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Failed to update category.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryRepository->find($id);
            return view('admin.category.show', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('categories.index')->withErrors(['error' => 'Category not found.']);
        } catch (Throwable $e) {
            return redirect()->route('categories.index')->withErrors(['error' => 'Failed to load category details.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (Throwable $e) {
            return redirect()->route('categories.index')->withErrors(['error' => 'Failed to delete category.']);
        }
    }
}
