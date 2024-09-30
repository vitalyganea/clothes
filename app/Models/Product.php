<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'shop_id',
        'user_id',
        'price',
        'category_id',
        'size_id',
        'city_id',
    ];


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function productSize()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function uniqueViews()
    {
        return $this->hasMany(ProductView::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function isWishlist() {
        return $this->hasOne(Wishlist::class, 'product_id')
            ->where('user_id', auth()->id());
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
