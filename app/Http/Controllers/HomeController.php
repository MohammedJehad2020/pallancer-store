<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        //لتظهر صور اخر 10 منتجات في الصفحة الرئيسية
        $latest = Product::latest()->take(10)->get();// بترجع اخر 10 منتجات تم اضافتها
        return view('front.home', [
            'latest' => $latest,
        ]);
    }
}
