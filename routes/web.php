<?php

use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/category/{category}', [ProductController::class, 'index'])->name('category.index');
Route::resource('shops', ShopController::class);
Route::get('my-shops', [ShopController::class,'myShops'])->name('shop.my-shops')->middleware('auth');
Route::get('shops/{shop}/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('shops/{shop}/products', [ProductController::class, 'store'])->name('products.store');


Route::get('/shops/{id}/edit', [ShopController::class, 'edit'])->name('shops.edit');
Route::put('/shops/{id}', [ShopController::class, 'update'])->name('shops.update');
Route::delete('/shops/{id}', [ShopController::class, 'destroy'])->name('shops.destroy');

// Product routes
Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/shops/{id}/products', [ProductController::class, 'shopProducts'])->name('shops.products');

Route::delete('/product-image/{id}', [ProductImageController::class, 'deleteImage'])->name('product-image.delete');


Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


// Route to display all shops
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');

// Route to show the form for creating a new shop
Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');

// Route to store a newly created shop
Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
