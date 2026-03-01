<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function products()
    {
        return view('admin.products.index');
    }

    public function categories()
    {
        return view('admin.categories.index');
    }

    public function testimonials()
    {
        return view('admin.testimonials.index');
    }

    public function banners()
    {
        return view('admin.banners.index');
    }

    public function users()
    {
        return view('admin.users.index');
    }
}
