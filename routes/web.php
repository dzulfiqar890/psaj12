<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\ViewController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [App\Http\Controllers\Admin\ViewController::class, 'products'])->name('admin.products.index'); // naming convention fix
    Route::get('/categories', [App\Http\Controllers\Admin\ViewController::class, 'categories'])->name('admin.categories.index');
    Route::get('/testimonials', [App\Http\Controllers\Admin\ViewController::class, 'testimonials'])->name('admin.testimonials.index');
    Route::get('/contacts', [App\Http\Controllers\Admin\ViewController::class, 'contacts'])->name('admin.contacts.index');
    Route::get('/banners', [App\Http\Controllers\Admin\ViewController::class, 'banners'])->name('admin.banners.index');
    Route::get('/users', [App\Http\Controllers\Admin\ViewController::class, 'users'])->name('admin.users.index');
});

// Auth Routes (Session)
Route::get('/login', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/');
    }
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect('/');
    }
    return view('auth.register');
})->name('register');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::guard('web')->attempt($credentials)) {
        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
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
