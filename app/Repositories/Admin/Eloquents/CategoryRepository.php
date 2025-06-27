<?php

namespace App\Repositories\Admin\Eloquents;

use App\Models\Category;
use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::with('subcategories')->paginate(10);
    }

    public function find($id)
    {
        return Category::with('subcategories')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }
}
