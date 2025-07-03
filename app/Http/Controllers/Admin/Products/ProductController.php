<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepository;
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): View|RedirectResponse
    {
        try {
            $products = $this->productRepository->all();
            return view('admin.products.index', compact('products'));
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to load products.']);
        }
    }

    public function create(): View|RedirectResponse
    {
        try {
            $mainCategories = $this->categoryRepository->all()->whereNull('parent_id');
            return view('admin.products.create', compact('mainCategories'));
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to load form.']);
        }
    }

    public function store(StoreProductRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $validated = $this->prepareValidatedProductData($request);

            $this->productRepository->createProduct($validated);

            return $request->expectsJson()
                ? response()->json([
                    'message' => 'Product created successfully.',
                    'redirect' => route('admin.products.index')
                ], 201)
                : redirect()->route('admin.products.index')->with('success', 'Product created successfully.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to create product.'])->withInput();
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        try {
            $products = $this->productRepository->find($id);
            $mainCategories = $this->categoryRepository->all()->whereNull('parent_id');
            return view('admin.products.edit', compact('products', 'mainCategories'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.products.index')->withErrors(['error' => 'Product not found.']);
        } catch (Throwable $e) {
            return redirect()->route('admin.products.index')->withErrors(['error' => 'Failed to load edit form.']);
        }
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse|JsonResponse
    {
        try {
            $validated = $this->prepareValidatedProductData($request);

            $this->productRepository->update($id, $validated);

            return $request->expectsJson()
                ? response()->json([
                    'message' => 'Product updated successfully.',
                    'redirect' => route('admin.products.index')
                ], 200)
                : redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['error' => 'Product not found.']);
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to update product.'])->withInput();
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->productRepository->delete($id);
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['error' => 'Product not found.']);
        } catch (Throwable $e) {
            return back()->withErrors(['error' => 'Failed to delete product.']);
        }
    }

    /**
     * Prepare validated product data for storage or update.
     *
     * @param Request $request
     * @return array
     */
    protected function prepareValidatedProductData(Request $request): array
    {
        $validated = $request->validated();

        // Normalize boolean fields
        foreach (['is_featured', 'is_hot_trend', 'is_new_arrival'] as $key) {
            $validated[$key] = filter_var($validated[$key] ?? false, FILTER_VALIDATE_BOOLEAN);
        }

        // Process images
        $validated['images'] = collect($request->file('product_images') ?? [])
            ->filter(fn($file) => $file->isValid())
            ->all();

        // Generate variants (color + size combinations)
        $colors = $validated['colors'] ?? [];
        $sizes = $validated['sizes'] ?? [];

        $validated['variants'] = collect($colors)
            ->flatMap(fn($color) => collect($sizes)->map(fn($size) => ['color' => $color, 'size' => $size]))
            ->values()
            ->all();

        unset($validated['colors'], $validated['sizes'], $validated['product_images']);

        return $validated;
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'image_path' => 'required|string',
            'product_id' => 'required|integer|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        $image = $product->images()->where('image_path', 'like', "%{$request->image_path}")->first();

        if (!$image) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        // Delete from storage
        Storage::disk('public')->delete($image->image_path);

        // Delete from database
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully.']);
    }
}
