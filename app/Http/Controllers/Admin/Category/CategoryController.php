<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;
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
            report($e);
            return back()->withErrors(['error' => 'Failed to load categories.']);
        }
    }

    public function create()
    {
        try {
            $mainCategories = $this->categoryRepository->all()->whereNull('parent_id');
            return view('admin.category.create', compact('mainCategories'));
        } catch (Throwable $e) {
            report($e);
            return back()->withErrors(['error' => 'Failed to load form.']);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $this->validateData($request);

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('categories', 'public');
            }

            $this->categoryRepository->create($data);

            return $this->handleSuccess($request, 'Category created successfully.', route('admin.categories.index'));
        } catch (ValidationException $e) {
            return $this->handleValidationError($request, $e);
        } catch (Throwable $e) {
            report($e);
            return $this->handleServerError($request, 'Failed to create category.');
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
            return redirect()->route('admin.categories.index')->withErrors(['error' => 'Category not found.']);
        } catch (Throwable $e) {
            report($e);
            return redirect()->route('admin.categories.index')->withErrors(['error' => 'Failed to load edit form.']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = $this->categoryRepository->find($id);
            $data = $this->validateData($request);
        
            if ($request->hasFile('thumbnail')) {
                if ($category->thumbnail && Storage::disk('public')->exists($category->thumbnail)) {
                    Storage::disk('public')->delete($category->thumbnail);
                }
                $data['thumbnail'] = $request->file('thumbnail')->store('categories', 'public');
            } else {
                $data['thumbnail'] = $category->thumbnail;
            }

            $this->categoryRepository->update($id, $data);

            return $this->handleSuccess($request, 'Category updated successfully.', route('admin.categories.index'));
        } catch (ValidationException $e) {
            return $this->handleValidationError($request, $e);
        } catch (Throwable $e) {
            report($e);
            return $this->handleServerError($request, 'Failed to update category.');
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryRepository->find($id);
            return view('admin.category.show', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.categories.index')->withErrors(['error' => 'Category not found.']);
        } catch (Throwable $e) {
            report($e);
            return redirect()->route('admin.categories.index')->withErrors(['error' => 'Failed to load category details.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryRepository->delete($id);
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
        } catch (Throwable $e) {
            report($e);
            return redirect()->route('admin.categories.index')->withErrors(['error' => 'Failed to delete category.']);
        }
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'image_path' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $category = Category::findOrFail($request->category_id);

        if ($category->thumbnail && str_contains($category->thumbnail, $request->image_path)) {
            if (Storage::disk('public')->exists($category->thumbnail)) {
                Storage::disk('public')->delete($category->thumbnail);
            }

            $category->update(['thumbnail' => null]);

            return response()->json(['message' => 'Image deleted successfully.']);
        }

        return response()->json(['message' => 'Image not found.'], 404);
    }

    /**
     * Validate and return sanitized data for category form.
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|max:2048',
        ]);
    }

    /**
     * Return a standard JSON or web response on success.
     */
    protected function handleSuccess(Request $request, string $message, string $redirect)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'redirect' => $redirect,
            ], 200);
        }

        return redirect()->to($redirect)->with('success', $message);
    }

    /**
     * Return response for validation errors.
     */
    protected function handleValidationError(Request $request, ValidationException $e)
    {
        if ($request->expectsJson()) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        return back()->withErrors($e->validator)->withInput();
    }

    /**
     * Return response for unexpected errors.
     */
    protected function handleServerError(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => $message], 500);
        }

        return back()->withErrors(['error' => $message])->withInput();
    }
}
