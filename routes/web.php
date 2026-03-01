<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/produk/{slug}', function ($slug) {
    return view('detail-produk', ['slug' => $slug]);
})->name('produk.detail');

Route::get('/kategori', function (Illuminate\Http\Request $request) {
    return view('kategori');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\ViewController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [App\Http\Controllers\Admin\ViewController::class, 'products'])->name('admin.products.index');
    Route::get('/categories', [App\Http\Controllers\Admin\ViewController::class, 'categories'])->name('admin.categories.index');
    Route::get('/testimonials', [App\Http\Controllers\Admin\ViewController::class, 'testimonials'])->name('admin.testimonials.index');
    Route::get('/banners', [App\Http\Controllers\Admin\ViewController::class, 'banners'])->name('admin.banners.index');
    Route::get('/users', [App\Http\Controllers\Admin\ViewController::class, 'users'])->name('admin.users.index');
});

// Socialite Routes (Google Login)
Route::get('/auth/google/redirect', [App\Http\Controllers\SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\SocialiteController::class, 'handleGoogleCallback']);

// Auth Routes (Session)
Route::get('/login', function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::guard('web')->attempt($credentials)) {
        $request->session()->regenerate();

        if (Auth::user()->is_admin) {
            return redirect()->intended('admin/dashboard');
        }

        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
