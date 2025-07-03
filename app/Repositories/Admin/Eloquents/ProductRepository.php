<?php

namespace App\Repositories\Admin\Eloquents;

use App\Models\Product;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products with relationships.
     *
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator
    {
        return Product::with(['category', 'images', 'variants', 'reviews'])->paginate(10);
    }

    /**
     * Store a new product with images and variants.
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        $images = $data['images'] ?? [];
        $variants = $data['variants'] ?? [];

        unset($data['images'], $data['variants']);

        $product = Product::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'] ?? null,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'discount_price' => $data['discount_price'] ?? null,
            'is_featured' => $data['is_featured'] ?? false,
            'is_hot_trend' => $data['is_hot_trend'] ?? false,
            'is_new_arrival' => $data['is_new_arrival'] ?? false,
            'stock' => $data['stock'] ?? 0,
        ]);

        $this->storeImages($product, $images);
        $this->storeVariants($product, $variants);

        return $product;
    }

    /**
     * Find a product by ID with its relationships.
     *
     * @param int $id
     * @return Product
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id): Product
    {
        return Product::with(['category', 'images', 'variants', 'reviews'])->findOrFail($id);
    }

    /**
     * Update an existing product with images and variants.
     *
     * @param int $id
     * @param array $data
     * @return Product
     */
    public function update(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);

        $images = $data['images'] ?? [];
        $variants = $data['variants'] ?? [];

        unset($data['images'], $data['variants']);

        $product->update($data);

        if (!empty($images)) {
            $this->storeImages($product, $images);
        }

        // Replace variants
        $product->variants()->delete();
        $this->storeVariants($product, $variants);

        return $product;
    }

    /**
     * Delete a product by ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        return Product::destroy($id) > 0;
    }

    /**
     * Store uploaded images for a product.
     *
     * @param Product $product
     * @param array $images
     * @return void
     */
    protected function storeImages(Product $product, array $images): void
    {
        foreach ($images as $image) {
            if ($image instanceof UploadedFile && $image->isValid()) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }
    }

    /**
     * Store variant combinations for a product.
     *
     * @param Product $product
     * @param array $variants
     * @return void
     */
    protected function storeVariants(Product $product, array $variants): void
    {
        foreach ($variants as $variant) {
            $product->variants()->create([
                'color' => $variant['color'],
                'size' => $variant['size'],
            ]);
        }
    }
}
