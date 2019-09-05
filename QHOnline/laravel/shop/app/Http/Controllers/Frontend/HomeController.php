<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Trang chủ
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::orderBy('id', 'desc')->limit(8)->get();
        return view('frontend.default.index', $data);
    }

    /**
     * Đây là trang hiển thị sản phẩm
     */
    public function show($slug, $id) {
        $data['product'] = Product::find($id);
        // dd($data);
        return view('frontend.default.single-product', $data);
    }
}
