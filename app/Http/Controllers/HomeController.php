<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch paginated products

        $products = Product::with('images')->paginate(12); // 12 products per page

        $productCategories = ProductCategory::all();

        return view('products.index', compact(['products', 'productCategories']));
    }
}
