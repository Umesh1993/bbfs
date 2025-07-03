<?php

namespace App\Repositories\Admin\Contracts;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    /**
     * Get all products with relationships, paginated.
     *
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * Store a new product along with images and variants.
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * Find a product by its ID with relationships.
     *
     * @param int $id
     * @return Product
     */
    public function find(int $id): Product;

    /**
     * Update a product and its related data.
     *
     * @param int $id
     * @param array $data
     * @return Product
     */
    public function update(int $id, array $data): Product;

    /**
     * Delete a product by its ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
