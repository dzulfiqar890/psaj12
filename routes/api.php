<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Customer\ContactController as CustomerContactController;
use App\Http\Controllers\Api\PublicApi\BannerController as PublicBannerController;
use App\Http\Controllers\Api\PublicApi\CategoryController as PublicCategoryController;
use App\Http\Controllers\Api\PublicApi\ProductController as PublicProductController;
use App\Http\Controllers\Api\PublicApi\TestimonialController as PublicTestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Katalog Gitar
|--------------------------------------------------------------------------
|
| Semua route API untuk aplikasi katalog gitar.
| Route dikelompokkan berdasarkan level akses:
| - Public (Guest/Customer): Tanpa autentikasi untuk Guest, Customer juga bisa akses
| - Customer Only: Membutuhkan login (contact)
| - Admin: Membutuhkan login + role admin
|
*/

// ============================================================
// PUBLIC ROUTES (Guest & Customer - Tanpa Autentikasi Required)
// Customer yang login juga bisa mengakses route ini
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
    Route::post('/register/send-verification', [AuthController::class, 'sendVerification'])
        ->middleware('throttle:5,1'); // Rate limit: 5 requests per menit

    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1'); // Rate limit: 5 requests per menit

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1'); // Rate limit: 5 requests per menit

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
});

// ============================================================
// CUSTOMER ROUTES (Membutuhkan Autentikasi)
// Fitur tambahan untuk customer: Contact & Auth actions
// Customer juga bisa akses semua Public Routes di atas
// ============================================================
Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

    // Auth actions
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Customer Contact (kirim pesan) - Hanya customer yang bisa akses
    Route::post('/contacts', [CustomerContactController::class, 'store']);
    Route::get('/my-contacts', [CustomerContactController::class, 'myContacts']);
});

// ============================================================
// ADMIN ROUTES (Membutuhkan Autentikasi + Role Admin)
// ============================================================
Route::prefix('v1/admin')
    ->middleware(['auth:sanctum', 'role:admin', 'throttle:120,1'])
    ->group(function () {

        // Users Management
        Route::apiResource('users', AdminUserController::class);

        // Categories Management
        // Menggunakan Hybrid Binding (ID atau Slug)
        Route::get('categories', [AdminCategoryController::class, 'index']); //->name('admin.categories.index')
        Route::post('categories', [AdminCategoryController::class, 'store']); //->name('admin.categories.store')
        Route::get('categories/{category}', [AdminCategoryController::class, 'show']); //->name('admin.categories.show')
        Route::put('categories/{category}', [AdminCategoryController::class, 'update']); //->name('admin.categories.update')
        Route::patch('categories/{category}', [AdminCategoryController::class, 'update']);
        Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy']); //->name('admin.categories.destroy')
    
        // Products Management
        // Menggunakan Hybrid Binding (ID atau Slug)
        Route::get('products', [AdminProductController::class, 'index']); //->name('admin.products.index')
        Route::post('products', [AdminProductController::class, 'store']); //->name('admin.products.store')
        Route::get('products/{product}', [AdminProductController::class, 'show']); //->name('admin.products.show')
        Route::put('products/{product}', [AdminProductController::class, 'update']); //->name('admin.products.update')
        Route::patch('products/{product}', [AdminProductController::class, 'update']);
        Route::delete('products/{product}', [AdminProductController::class, 'destroy']); //->name('admin.products.destroy')
    
        // Banners Management
        Route::apiResource('banners', AdminBannerController::class);

        // Testimonials Management
        Route::apiResource('testimonials', AdminTestimonialController::class);

        // Contacts Management (Read only + update status)
        Route::apiResource('contacts', AdminContactController::class)
            ->only(['index', 'show', 'update']);

        // Dashboard Stats
        Route::get('stats', [App\Http\Controllers\Api\Admin\DashboardController::class, 'stats'])->name('admin.stats');
    });

