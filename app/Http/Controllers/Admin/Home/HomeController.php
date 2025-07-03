<?php

namespace App\Http\Controllers\Admin\Home;

use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;

class HomeController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->all();

        return view('admin.home.index', compact('categories'));
    }
}
