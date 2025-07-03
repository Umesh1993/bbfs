<?php

namespace App\Repositories\Admin\Eloquents;

use App\Models\Category;
use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories with pagination and subcategories.
     */
    public function all(): LengthAwarePaginator
    {
        return Category::with('subcategories')->paginate(10);
    }

    /**
     * Find a category by ID with subcategories.
     */
    public function find(int $id): Category
    {
        return Category::with('subcategories')->findOrFail($id);
    }

    /**
     * Create a new category.
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update an existing category.
     */
    public function update(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    /**
     * Delete a category by ID.
     */
    public function delete(int $id): bool
    {
        return Category::destroy($id) > 0;
    }
}
