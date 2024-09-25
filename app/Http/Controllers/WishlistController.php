<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index()
    {
        $products = Product::whereHas('wishlists', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
        return view('wishlist.index', compact('products'));

    }

    public function remove($id)
    {
        $wishlistItem = Wishlist::where('product_id', $id)->where('user_id', auth()->id())->first();
        if ($wishlistItem) {
            $wishlistItem->delete();
            return redirect()->route('wishlist.index')->with('success', 'Product removed from wishlist.');
        }

        return redirect()->route('wishlist.index')->with('error', 'Product not found.');
    }

    public function add(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Check if the product is already in the user's wishlist
        $existingWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if (!$existingWishlist) {
            // Save to wishlist
            $wishlist = new Wishlist();
            $wishlist->user_id = auth()->id(); // Assuming you have user authentication
            $wishlist->product_id = $request->product_id;
            $wishlist->save();

            return response()->json(['message' => 'Product added to wishlist successfully.']);
        }
    }

}
