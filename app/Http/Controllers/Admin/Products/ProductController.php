<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use App\Http\Requests\Admin\StoreProductRequest;

class ProductController extends Controller
{

    protected ProductRepositoryInterface $productRepository;
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index() {
        try {
            $products = $this->productRepository->all();
            return view('admin.products.index', compact('products'));
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to load products.']);
        }
    }

    public function create()
    {
        try {
            $mainCategories = $this->categoryRepository->all()->whereNull('parent_id');
            return view('admin.products.create', compact('mainCategories'));
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to load form.']);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();

            // Normalize booleans if needed (optional, Laravel handles 'true'/'false' via boolean rule)
            $validated['is_featured'] = filter_var($validated['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $validated['is_hot_trend'] = filter_var($validated['is_hot_trend'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $validated['is_new_arrival'] = filter_var($validated['is_new_arrival'] ?? false, FILTER_VALIDATE_BOOLEAN);

            // Extract and attach product images
            $validated['images'] = [];
            if ($request->hasFile('product_images')) {
                foreach ($request->file('product_images') as $image) {
                    $validated['images'][] = $image;
                }
            }

            // Generate variant combinations from colors and sizes
            $colors = $validated['colors'] ?? [];
            $sizes = $validated['sizes'] ?? [];
            $variants = [];

            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    $variants[] = compact('color', 'size');
                }
            }

            $validated['variants'] = $variants;

            // Remove keys no longer needed
            unset($validated['colors'], $validated['sizes'], $validated['product_images']);

            // Store product

            $this->productRepository->createProduct($validated);

           
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to create product.'])->withInput();
        }
    }


    public function update(StoreProductRequest $request, $id) {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'featured' => 'nullable|boolean',
                'new_arrival' => 'nullable|boolean',
                'hot_trend' => 'nullable|boolean',
                'description' => 'nullable|string',
                'thumbnail' => 'nullable|image|max:2048',
                // Add more fields as needed
            ]);

            if ($request->hasFile('thumbnail')) {
                $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
            }

            $this->productRepository->update($id, $validated);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['error' => 'Product not found.']);
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to update product.'])->withInput();
        }
    }

    public function destroy($id) {
        try {
            $this->productRepository->delete($id);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['error' => 'Product not found.']);
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to delete product.']);
        }
    }
}
