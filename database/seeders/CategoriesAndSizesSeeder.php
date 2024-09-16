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
            'Footwear' => [
                '36', '37', '38', '39', '40', '41', '42', '42.5', '43', '44', '45', '46', '47', '48', '49', '50'
            ],
            'Jewelry' => ['XS', 'Small', 'Medium', 'Large', 'X-Large', 'XX-Large'],
            'Clothing' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', '4XL', '5XL'],
            'Accessories' => ['One Size', 'Adjustable', 'Small', 'Medium', 'Large'],
            'Outerwear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL'],
            'Bags' => ['Mini', 'Small', 'Medium', 'Large', 'Extra Large'],
            'Sportswear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Hats' => ['XS', 'Small', 'Medium', 'Large', 'Extra Large'],
            'Sunglasses' => ['One Size', 'Small', 'Medium', 'Large'],
            'Watches' => ['Small', 'Medium', 'Large', 'Extra Large', 'Adjustable'],
            'Scarves' => ['One Size', 'Small', 'Medium', 'Large'],
            'Belts' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Socks' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'],
            'Undergarments' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Swimwear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'],
            'Gloves' => ['XS', 'Small', 'Medium', 'Large', 'Extra Large', 'XXL'],
            'Loungewear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Formalwear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Casualwear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Sleepwear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL'],
            'Fitness Apparel' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Activewear' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Handbags' => ['Mini', 'Small', 'Medium', 'Large', 'Extra Large'],
            'Backpacks' => ['Mini', 'Small', 'Medium', 'Large', 'Extra Large'],
            'Foot Accessories' => ['One Size', 'Small', 'Medium', 'Large', 'Extra Large'],
            'Ties & Bowties' => ['One Size', 'Adjustable', 'Small', 'Medium', 'Large'],
            'Blazers' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Dresses' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Skirts' => ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'],
            'Pants' => ['26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '42', '44', '46', '48'],
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
