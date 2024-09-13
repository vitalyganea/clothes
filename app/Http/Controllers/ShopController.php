<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    // Display the form to create a new shop
    public function create()
    {
        return view('shops.create');
    }

    // Store a newly created shop in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|nullable|max:1999'
        ]);

        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $shop->image = $request->file('image')->store('public/shop_images');
        }

        $shop->save();

        return redirect()->route('shops.index')->with('success', 'Shop created successfully!');
    }

    // Display a listing of the shops
    public function index()
    {
        $shops = Shop::with('products')->where('user_id', auth()->id())->get();
        return view('shops.index', compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|nullable|max:1999'
        ]);

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($shop->image) {
                Storage::delete($shop->image);
            }
            $shop->image = $request->file('image')->store('public/shop_images');
        }

        $shop->save();

        return redirect()->route('shops.index')->with('success', 'Shop updated successfully!');
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);

        // Delete all associated products
        foreach ($shop->products as $product) {
            foreach ($product->images as $image) {
                Storage::delete($image->path);
            }
            $product->delete();
        }

        // Delete the shop image
        if ($shop->image) {
            Storage::delete($shop->image);
        }

        $shop->delete();

        return redirect()->route('shops.index')->with('success', 'Shop deleted successfully!');
    }

}
