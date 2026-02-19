<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/katalog', function () {
    $products = [
        ['id' => 0, 'nama' => 'Yamaha C315', 'harga' => 'Rp900.000 - Rp1.150.000', 'gambar' => 'Foto/10.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 1, 'nama' => 'Yamaha CS40', 'harga' => 'Rp1.310.000 - Rp1.638.000', 'gambar' => 'Foto/2.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 2, 'nama' => 'Yamaha C40', 'harga' => 'Rp1.414.000 - Rp1.704.000', 'gambar' => 'Foto/3.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 3, 'nama' => 'Yamaha C315', 'harga' => 'Rp900.000 - Rp1.150.000', 'gambar' => 'Foto/4.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 4, 'nama' => 'Yamaha F310', 'harga' => 'Rp 1.100.000 - Rp 1.300.000', 'gambar' => 'Foto/9.jpg', 'kategori' => 'Gitar Akustik'],
        ['id' => 5, 'nama' => 'Yamaha APX600', 'harga' => 'Rp 3.165.000 - Rp 3.300.000', 'gambar' => 'Foto/11.jpg', 'kategori' => 'Gitar Akustik'],
        ['id' => 6, 'nama' => 'Cort AD810', 'harga' => 'Rp 850.000 - Rp 1.300.000', 'gambar' => 'Foto/12.jpg', 'kategori' => 'Gitar Akustik'],
        ['id' => 7, 'nama' => 'Yamaha JR1', 'harga' => 'Rp 1.285.000', 'gambar' => 'Foto/13.png', 'kategori' => 'Gitar Akustik'],
    ];
    return view('katalog', ['products' => $products]);
});

Route::get('/produk/{id}', function ($id) {
    $products = [
        ['id' => 0, 'nama' => 'Yamaha C315', 'harga' => 'Rp900.000 - Rp1.150.000', 'gambar' => 'Foto/10.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 1, 'nama' => 'Yamaha CS40', 'harga' => 'Rp1.310.000 - Rp1.638.000', 'gambar' => 'Foto/2.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 2, 'nama' => 'Yamaha C40', 'harga' => 'Rp1.414.000 - Rp1.704.000', 'gambar' => 'Foto/3.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 3, 'nama' => 'Yamaha C315', 'harga' => 'Rp900.000 - Rp1.150.000', 'gambar' => 'Foto/4.png', 'kategori' => 'Gitar Klasik'],
        ['id' => 4, 'nama' => 'Yamaha F310', 'harga' => 'Rp 1.100.000 - Rp 1.300.000', 'gambar' => 'Foto/9.jpg', 'kategori' => 'Gitar Akustik'],
        ['id' => 5, 'nama' => 'Yamaha APX600', 'harga' => 'Rp 3.165.000 - Rp 3.300.000', 'gambar' => 'Foto/11.jpg', 'kategori' => 'Gitar Akustik'],
        ['id' => 6, 'nama' => 'Cort AD810', 'harga' => 'Rp 850.000 - Rp 1.300.000', 'gambar' => 'Foto/12.jpg', 'kategori' => 'Gitar Akustik'],
        ['id' => 7, 'nama' => 'Yamaha JR1', 'harga' => 'Rp 1.285.000', 'gambar' => 'Foto/13.png', 'kategori' => 'Gitar Akustik'],
    ];

    $product = collect($products)->firstWhere('id', $id);

    if (!$product) {
        abort(404);
    }

    return view('detail-produk', ['product' => $product]);
})->name('produk.detail');

Route::get('/detail-katalog', function (Illuminate\Http\Request $request) {
    $jenis = $request->query('jenis', 'all');

    $allGuitars = [
        'classic' => [
            ['nama' => 'Yamaha C315', 'harga' => 'Rp 900.000', 'gambar' => 'Foto/10.png'],
            ['nama' => 'Yamaha C40', 'harga' => 'Rp 1.150.000', 'gambar' => 'Foto/3.png'],
            ['nama' => 'Cort AC100', 'harga' => 'Rp 850.000', 'gambar' => 'Foto/2.png'],
            ['nama' => 'Ibanez GA15', 'harga' => 'Rp 1.300.000', 'gambar' => 'Foto/4.png'],
            ['nama' => 'Admira Alba', 'harga' => 'Rp 2.100.000', 'gambar' => 'Foto/10.png'],
            ['nama' => 'Valencia VC104', 'harga' => 'Rp 750.000', 'gambar' => 'Foto/3.png'],
        ],
        'akustik' => [
            ['nama' => 'Taylor 214ce', 'harga' => 'Rp 15.500.000', 'gambar' => 'Foto/2.png'],
            ['nama' => 'Martin D-28', 'harga' => 'Rp 25.000.000', 'gambar' => 'Foto/4.png'],
            ['nama' => 'Yamaha FG800', 'harga' => 'Rp 3.200.000', 'gambar' => 'Foto/3.png'],
            ['nama' => 'Epiphone Hummingbird', 'harga' => 'Rp 5.400.000', 'gambar' => 'Foto/10.png'],
            ['nama' => 'Fender CD-60S', 'harga' => 'Rp 3.800.000', 'gambar' => 'Foto/2.png'],
            ['nama' => 'Cort Earth 70', 'harga' => 'Rp 2.500.000', 'gambar' => 'Foto/4.png'],
        ],
        'elektrik' => [
            ['nama' => 'Fender Stratocaster', 'harga' => 'Rp 18.000.000', 'gambar' => 'Foto/8.png'],
            ['nama' => 'Gibson Les Paul', 'harga' => 'Rp 32.000.000', 'gambar' => 'Foto/1.png'],
            ['nama' => 'Ibanez RG550', 'harga' => 'Rp 12.500.000', 'gambar' => 'Foto/8.png'],
            ['nama' => 'PRS SE Custom 24', 'harga' => 'Rp 9.800.000', 'gambar' => 'Foto/1.png'],
            ['nama' => 'ESP LTD EC-256', 'harga' => 'Rp 6.200.000', 'gambar' => 'Foto/8.png'],
            ['nama' => 'Squier Telecaster', 'harga' => 'Rp 3.500.000', 'gambar' => 'Foto/1.png'],
        ],
    ];

    $kategoriLabels = [
        'classic' => 'Classic Gitar',
        'akustik' => 'Akustik Gitar',
        'elektrik' => 'Elektrik Gitar',
        'all' => 'Semua Gitar',
    ];

    if ($jenis === 'all') {
        $guitars = array_merge($allGuitars['classic'], $allGuitars['akustik'], $allGuitars['elektrik']);
    } else {
        $guitars = $allGuitars[$jenis] ?? [];
    }

    $kategori = $kategoriLabels[$jenis] ?? 'Semua Gitar';

    return view('detail-katalog', [
        'guitars' => $guitars,
        'kategori' => $kategori,
        'jenisAktif' => $jenis,
    ]);
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
