<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\PublicApi\BannerController as PublicBannerController;
use App\Http\Controllers\Api\PublicApi\CategoryController as PublicCategoryController;
use App\Http\Controllers\Api\PublicApi\ProductController as PublicProductController;
use App\Http\Controllers\Api\PublicApi\TestimonialController as PublicTestimonialController;
use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Katalog Gitar
|--------------------------------------------------------------------------
|
| Semua route API untuk aplikasi katalog gitar.
| Route dikelompokkan berdasarkan level akses:
| - Public (Guest): Tanpa autentikasi
| - Admin: Membutuhkan login + isAdmin
|
*/

// ============================================================
// PUBLIC ROUTES (Tanpa Autentikasi)
// ============================================================
Route::prefix('v1')->group(function () {

    // Root Endpoint
    Route::get('/', function () {
        return response()->json([
            'success' => true,
            'message' => 'Selamat datang di API Katalog Gitar v1',
            'version' => '1.0.0'
        ]);
    });

    // Authentication
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1');

    // Public Products (dengan search, filter, pagination)
    Route::get('/products', [PublicProductController::class, 'index']);
    Route::get('/products/{product:slug}', [PublicProductController::class, 'show']);

    // Public Categories
    Route::get('/categories', [PublicCategoryController::class, 'index']);
    Route::get('/categories/{category:slug}', [PublicCategoryController::class, 'show']);

    // Public Banners (hanya yang aktif)
    Route::get('/banners', [PublicBannerController::class, 'index']);

    // Public Testimonials (hanya yang aktif)
    Route::get('/testimonials', [PublicTestimonialController::class, 'index']);

    // Chatbot AI (publik, throttled)
    Route::post('/chatbot', [ChatbotController::class, 'chat'])
        ->middleware('throttle:30,1');
});

// ============================================================
// AUTHENTICATED ROUTES (Membutuhkan Login)
// ============================================================
Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

    // Auth actions
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// ============================================================
// ADMIN ROUTES (Membutuhkan Autentikasi + isAdmin)
// ============================================================
Route::prefix('v1/admin')
    ->middleware(['auth:sanctum', 'admin', 'throttle:120,1'])
    ->group(function () {

        // Users Management
        Route::apiResource('users', AdminUserController::class);

        // Categories Management
        Route::get('categories', [AdminCategoryController::class, 'index']);
        Route::post('categories', [AdminCategoryController::class, 'store']);
        Route::get('categories/{category}', [AdminCategoryController::class, 'show']);
        Route::put('categories/{category}', [AdminCategoryController::class, 'update']);
        Route::patch('categories/{category}', [AdminCategoryController::class, 'update']);
        Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy']);
    
        // Products Management
        Route::get('products', [AdminProductController::class, 'index']);
        Route::post('products', [AdminProductController::class, 'store']);
        Route::get('products/{product}', [AdminProductController::class, 'show']);
        Route::put('products/{product}', [AdminProductController::class, 'update']);
        Route::patch('products/{product}', [AdminProductController::class, 'update']);
        Route::delete('products/{product}', [AdminProductController::class, 'destroy']);
    
        // Banners Management
        Route::apiResource('banners', AdminBannerController::class);

        // Testimonials Management
        Route::apiResource('testimonials', AdminTestimonialController::class);

        // Dashboard Stats
        Route::get('stats', [App\Http\Controllers\Api\Admin\DashboardController::class, 'stats'])->name('admin.stats');
    });
