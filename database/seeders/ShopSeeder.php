<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for($i = 1; $i <= 10; $i++){
            $userId = User::all()->random()->id;
            for($j = 1; $j <= 10; $j++){
                $shop = Shop::create([
                    'user_id' => $userId,
                    'name' => 'Shop - ' . $j,
                    'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                    'image' => 'https://ergo-store.com/wp-content/uploads/2018/11/levis_2.jpg'
                ]);
                for($k = 1; $k <= 10; $k++){

                    $categoryId = ProductCategory::all()->random()->id;
                    $sizeId = Size::all()->where('category_id', $categoryId)->random()->id;

                    Product::create([
                        'shop_id' => $shop->id,
                        'name' => 'Product - ' . $k,
                        'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                        'price' => rand(1, 100),
                        'user_id' => $userId,
                        'category_id' => $categoryId,
                        'size_id' => $sizeId,
                    ]);
                }
            }
        }

    }
}
