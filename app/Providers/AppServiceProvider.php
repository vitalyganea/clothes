<?php

namespace App\Providers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Check if the database connection is successful
            DB::connection()->getPdo();

            // Check if the 'product_categories' table exists
            if (Schema::hasTable('product_categories')) {
                $productCategories = ProductCategory::all();
                View::share('productCategories', $productCategories);
            } else {
                // Handle the case where the table doesn't exist
                View::share('productCategories', collect()); // Empty collection or any default value
            }
        } catch (\Exception $e) {
            // Handle the case where there is no connection or some other DB error
            View::share('productCategories', collect()); // Empty collection or any default value
        }
    }
}
