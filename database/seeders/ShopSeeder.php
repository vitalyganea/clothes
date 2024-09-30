<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Shop;
use App\Models\Size;
use App\Models\User;
use App\Models\City;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ShopSeeder extends Seeder
{
    protected const PRICES = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];
    protected const SUBPRICES = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];

    protected const BRANDS = [
                        'Nike',
                        'Adidas',
                        'Gucci',
                        'Zara',
                        'H&M',
                        'Levi\'s',
                        'Under Armour',
                        'Puma',
                        'Tommy Hilfiger',
                        'Calvin Klein',
                        'Reebok',
                        'Lululemon',
                        'Ralph Lauren',
                        'Versace',
                        'Vans',
                        'New Balance',
                        'Burberry',
                        'Fendi',
                        'Chanel',
                        'Asics',
                        'Skechers'
                        ];

    protected const MODELS = [
                        'Classic Tee',
                        'Running Shorts',
                        'Slim Fit Jeans',
                        'Summer Dress',
                        'Leather Jacket',
                        'Sports Bra',
                        'Hoodie',
                        'Cargo Pants',
                        'Tracksuit',
                        'Denim Jacket',
                        'Puffer Vest',
                        'Graphic T-shirt',
                        'Bomber Jacket',
                        'Chinos',
                        'Windbreaker',
                        'Maxi Dress',
                        'Jumpsuit',
                        'Sweatpants',
                        'Ripped Jeans',
                        'Tank Top',
                        'Athletic Leggings'
                        ];


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
                    $cityId = City::all()->random()->id;
                    $categoryId = ProductCategory::all()->random()->id;
                    $sizeId = Size::all()->where('category_id', $categoryId)->random()->id;

                    $product = Product::create([
                        'shop_id' => $shop->id,
                        'name' => $this->generateRandomProductName(),
                        'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                        'price' => (self::PRICES[array_rand(self::PRICES)] + self::SUBPRICES[array_rand(self::SUBPRICES)]),
                        'user_id' => $userId,
                        'category_id' => $categoryId,
                        'size_id' => $sizeId,
                        'city_id' => $cityId,
                    ]);
                    for ($k = 1; $k <= 10; $k++) {
                        $randomImageId = rand(1, 1000); // Adjust based on the range of available image IDs
                        $imageUrl = "https://picsum.photos/id/{$randomImageId}/200/200";

                        try {
                            // Fetch the image contents
                            $imageContents = @file_get_contents($imageUrl);

                            if ($imageContents === false) {
                                throw new Exception('Failed to fetch image');
                            }

                            // Define the local path
                            $localPath = public_path('/storage/product_images/' . $randomImageId . '.jpg');

                            // Save the image locally
                            file_put_contents($localPath, $imageContents);

                            // Save the path to the database
                            ProductImage::create([
                                'product_id' => $product->id,
                                'path' => '/storage/product_images/' . $randomImageId . '.jpg'
                            ]);

                        } catch (Exception $e) {
                            // Log the error or handle it as needed
                            Log::error('Error processing image ID ' . $randomImageId . ': ' . $e->getMessage());

                            // Optionally, you can also continue the loop or handle it differently
                            continue;
                        }
                    }
                }
            }
        }

    }

    public function generateRandomProductName()
    {
        // Randomly select a brand and model
        $randomBrand = self::BRANDS[array_rand(self::BRANDS)];
        $randomModel = self::MODELS[array_rand(self::MODELS)];

        // Output for testing
        return $randomBrand.' - '.$randomModel;
    }
}
