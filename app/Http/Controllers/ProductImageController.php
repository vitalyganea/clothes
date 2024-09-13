<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function deleteImage($imageId)
    {
        // Find the image by ID and delete it
        $image = ProductImage::findOrFail($imageId);

        // Delete the image file from the storage if necessary
        if (File::exists(public_path($image->path))) {
            File::delete(public_path($image->path));
        }

        // Delete the image record from the database
        $image->delete();

        // Return a JSON response
        return response()->json(['success' => true]);
    }
}
