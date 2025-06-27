<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Admin\Contracts\AuthRepositoryInterface;
use App\Repositories\Admin\Eloquents\AuthRepository;
use App\Repositories\Admin\Contracts\CategoryRepositoryInterface;
use App\Repositories\Admin\Eloquents\CategoryRepository;
use App\Repositories\Admin\Contracts\ProductRepositoryInterface;
use App\Repositories\Admin\Eloquents\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
         $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
         $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
