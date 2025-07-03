<?php

namespace App\Repositories\Admin\Contracts;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories with pagination.
     *
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;

    /**
     * Find a category by its ID.
     *
     * @param  int  $id
     * @return Category
     */
    public function find(int $id): Category;

    /**
     * Create a new category.
     *
     * @param  array  $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * Update the specified category.
     *
     * @param  int    $id
     * @param  array  $data
     * @return Category
     */
    public function update(int $id, array $data): Category;

    /**
     * Delete a category by ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool;
}
