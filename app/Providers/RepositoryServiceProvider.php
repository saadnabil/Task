<?php

namespace App\Providers;

use App\Eloquent\ProductRepositoryEloquent;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        app()->bind(ProductRepositoryInterface::class, ProductRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
