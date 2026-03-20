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
        return view('admin.products');
    }

    public function categories()
    {
        return view('admin.categories');
    }

    public function testimonials()
    {
        return view('admin.testimonials');
    }

    public function banners()
    {
        return view('admin.banners');
    }

    public function users()
    {
        return view('admin.users');
    }
}
