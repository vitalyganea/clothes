<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Shop;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request, $categoryId = null)
    {
        // Start query with eager loading
        $query = Product::with('images');

        // Conditionally add where clause if categoryId is set
        if (!is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // Fetch paginated products
        $products = $query->paginate(12); // 12 products per page

        return view('products.index', compact('products'));
    }

    public function shopProducts($shopId)
    {
        $shop = Shop::with('products')->findOrFail($shopId);
        return view('products.shopProducts', compact('shop'));
    }

    public function create($shopId)
    {
        $shop = Shop::find($shopId);
        $productSizes = Size::all();
        $productCategories = ProductCategory::all();
        return view('products.create', compact(['shop', 'productCategories', 'productSizes']));
    }

    public function store(Request $request, $shopId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
            'category_id' => 'required',
            'size_id' => 'required',
            'images.*' => 'image|nullable|max:1999'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->shop_id = $shopId;
        $product->user_id = Auth::user()->id;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->size_id = $request->size_id;
        $product->save();



        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/product_images');
                $url = Storage::url($path); // Generate the URL for the stored image

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $url // Save the URL instead of the path
                ]);
            }
        }

        return redirect()->route('shops.index')->with('success', 'Product created successfully!');
    }

    public function edit($productId)
    {

        $product = Product::where('id', $productId)->firstOrFail();


        return view('products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, $productId)
    {
        $product = Product::where('id', $productId)->firstOrFail();

        $shopId = $product->shop_id;

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|nullable|max:1999'
        ]);

        // Update the product details
        $product->update($request->except(['_token', '_method', 'images']));

        // Handle the image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public'); // Store in storage/app/public/product_images
                $url = Storage::url($path); // Generate the URL for the stored image

                // Create a new ProductImage record
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $url // Save the URL instead of the path
                ]);
            }
        }

        // Flash a success message
        session()->flash('success', 'Product updated successfully');

        return redirect()->route('products.edit', $product->id);
    }


    // Delete product
    public function destroy($product)
    {

        $product = Product::where('id', $product)->firstOrFail();

        $shopId = $product->shop_id;

        $product->delete();

        return redirect()->route('shops.products', $shopId)
            ->with('success', 'Product deleted successfully');
    }

    public function show($productId)
    {
        $product = Product::with(['images','shop', 'productCategory', 'productSize'])->findOrFail($productId);

        return view('products.show', compact('product'));
    }
}

