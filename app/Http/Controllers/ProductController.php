<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductView;
use App\Models\Shop;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request) {
        $products = Product::query();

        // Apply filters if they exist
        if ($request->has('category') && $request->get('category') != null) {
            $products->where('category_id', $request->category);
        }
        if ($request->has('size') && $request->get('size') != null) {
            $products->where('size_id', $request->size);
        }

        // Apply min and max price filters
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $products->where('price', '>=', (int)$request->min_price);
        }

        if ($request->filled('max_price') && $request->filled('min_price')) {
            $products->where('price', '<=', (int)$request->max_price);
        }


        switch ($request->sort) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'created_at_asc':
                $products->orderBy('created_at', 'asc');
                break;
            case 'created_at_desc':
                $products->orderBy('created_at', 'desc');
                break;
            default:
                $products->orderBy('created_at', 'desc'); // Default sorting if no sort option is selected
                break;
        }

        $products = $products->paginate(12);

        // Get the min and max price from the database
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        // Pass the previously selected category and size to the view
        return view('products.index', [
            'products' => $products,
            'productCategories' => ProductCategory::all(),
            'selectedCategory' => $request->category,
            'selectedSize' => $request->size,
            'minPrice' => $request->min_price ?? $minPrice,
            'maxPrice' => $request->max_price ?? $maxPrice,
            'filterIsEmpty' => $this->filterIsEmpty($request, $minPrice, $maxPrice),
        ]);
    }


    public function shopProducts($shopId)
    {
        $shop = Shop::with('products')->findOrFail($shopId);
        return view('products.myShopProducts', compact('shop'));
    }

    public function create($shopId)
    {
        $shop = Shop::find($shopId);
        $productSizes = Size::all();
        $productCategories = ProductCategory::all();
        return view('products.create', compact(['shop', 'productCategories']));
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

        return redirect()->route('shops.products', $product->shop_id)->with('success', 'Product created successfully!');
    }

    public function edit($productId)
    {
        $product = Product::where('id', $productId)->firstOrFail();
        $productSizes = Size::all();
        $productCategories = ProductCategory::all();
        return view('products.edit', compact(['product', 'productSizes', 'productCategories']));
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
        return redirect()->route('products.edit', $product->id)
            ->with('success', 'Product has been updated successfully.');
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

        $ipAddress = request()->ip();
        if (!ProductView::where('product_id', $productId)->where('ip_address', $ipAddress)->exists()) {
            ProductView::create([
                'product_id' => $productId,
                'ip_address' => $ipAddress,
            ]);
        }

        $product = Product::with(['images','shop', 'productCategory', 'productSize', 'uniqueViews'])->findOrFail($productId);

        return view('products.show', compact('product'));
    }

    public function getSizesByCategory($categoryId)
    {
        $sizes = Size::where('category_id', $categoryId)->get();

        return response()->json($sizes);
    }

    /**
     * @param Request $request
     * @param $minPrice
     * @param $maxPrice
     * @return bool
     */
    public function filterIsEmpty(Request $request, $minPrice, $maxPrice): bool
    {
        return (
            $request->category === null &&
            $request->size === null &&
            $request->sort === null &&
            ($request->min_price === null || $request->min_price === $minPrice) &&
            ($request->max_price === null || $request->max_price === $maxPrice)
        );
    }
}

