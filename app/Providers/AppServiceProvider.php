<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Hybrid Route Binding for Category (ID or Slug)
        \Illuminate\Support\Facades\Route::bind('category', function ($value) {
            return \App\Models\Category::where('id', $value)
                ->orWhere('slug', $value)
                ->firstOrFail();
        });

        // Hybrid Route Binding for Product (ID or Slug)
        \Illuminate\Support\Facades\Route::bind('product', function ($value) {
            return \App\Models\Product::where('id', $value)
                ->orWhere('slug', $value)
                ->firstOrFail();
        });
    }
}
