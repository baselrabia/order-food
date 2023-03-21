<?php

namespace App\Providers;

use App\Models\Ingredient;
use App\Observers\IngredientObserver;
use App\Repositories\Ingredient\IngredientRepository;
use App\Repositories\Ingredient\IngredientRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductCachedRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductCachedRepository::class);


        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(IngredientRepositoryInterface::class, IngredientRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Ingredient::observe(IngredientObserver::class);
    }
}
