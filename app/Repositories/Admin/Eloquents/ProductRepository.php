<?php

namespace App\Repositories\Admin\Eloquents;

use App\Models\Product;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all() {
        return Product::with(['category', 'variants', 'reviews'])->paginate(10);
    }

    public function createProduct(array $data)
    {
        $images = $data['images'] ?? [];
        $variants = $data['variants'] ?? [];

        // Remove relational data
        unset($data['images'], $data['variants']);

        // Create product

      
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

       // Store images
        foreach ($images as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create([
                'image_path' => $path,
            ]);
        }

        // Store variants
        foreach ($variants as $variant) {
            $product->variants()->create($variant);
        }

        return $product;
    }


    public function find($id) {
        return Product::with(['category', 'variants', 'reviews'])->findOrFail($id);
    }

    public function update($id, array $data) {

        $images = $data['images'] ?? [];
        unset($data['images']);

        $product = Product::findOrFail($id);
        $product->update($data);

        if (!empty($images)) {
            foreach ($images as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        $product->variants()->delete();
        if (!empty($data['variants'])) {
            foreach ($data['variants'] as $variant) {
                $product->variants()->create($variant);
            }
        }

        return $product;
    }

    public function delete($id) {
        return Product::destroy($id);
    }
}
