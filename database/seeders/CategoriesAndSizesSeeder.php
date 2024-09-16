<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesAndSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of categories with corresponding sizes
        $categories = [
            // Category => Sizes
            'Footwear' => ['42', '42.5', '43', '44'],
            'Jewelry' => ['Small', 'Medium', 'Large'],
            'Clothing' => ['S', 'M', 'L', 'XL'],
            'Accessories' => ['One Size'],
            'Outerwear' => ['S', 'M', 'L', 'XL'],
            'Bags' => ['Small', 'Medium', 'Large'],
            'Sportswear' => ['S', 'M', 'L', 'XL'],
            'Hats' => ['Small', 'Medium', 'Large'],
            'Sunglasses' => ['One Size'],
            'Watches' => ['Small', 'Medium', 'Large'],
            'Scarves' => ['One Size'],
            'Belts' => ['Small', 'Medium', 'Large'],
            'Socks' => ['S', 'M', 'L'],
            'Undergarments' => ['S', 'M', 'L', 'XL'],
            'Swimwear' => ['S', 'M', 'L'],
            'Gloves' => ['Small', 'Medium', 'Large'],
            'Loungewear' => ['S', 'M', 'L', 'XL'],
            'Formalwear' => ['S', 'M', 'L', 'XL'],
            'Casualwear' => ['S', 'M', 'L', 'XL'],
            'Sleepwear' => ['S', 'M', 'L', 'XL'],
            'Fitness Apparel' => ['S', 'M', 'L', 'XL'],
            'Activewear' => ['S', 'M', 'L', 'XL'],
            'Handbags' => ['Small', 'Medium', 'Large'],
            'Backpacks' => ['Small', 'Medium', 'Large'],
            'Foot Accessories' => ['One Size'],
            'Ties & Bowties' => ['One Size'],
            'Blazers' => ['S', 'M', 'L', 'XL'],
            'Dresses' => ['S', 'M', 'L', 'XL'],
            'Skirts' => ['S', 'M', 'L', 'XL'],
            'Pants' => ['28', '30', '32', '34'],
        ];

        // Seed categories and sizes
        foreach ($categories as $categoryName => $sizes) {
            // Insert category into the product_categories table
            $categoryId = DB::table('product_categories')->insertGetId([
                'name' => $categoryName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert sizes for this category into the sizes table
            foreach ($sizes as $size) {
                DB::table('sizes')->insert([
                    'size_name' => $size,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
