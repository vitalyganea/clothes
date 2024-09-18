<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search products
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        // Search shops
        $shops = Shop::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        $productHtml = '';
        foreach ($products as $product) {
            $productHtml .= view('partials.search-result-item', compact('product'))->render();
        }

        $shopHtml = '';
        foreach ($shops as $shop) {
            $shopHtml .= view('partials.search-result-item', compact('shop'))->render();
        }

        return response()->json([
            'html' => $productHtml . $shopHtml,
        ]);
    }
}
