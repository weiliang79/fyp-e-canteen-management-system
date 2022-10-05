<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(App::environment(['local', 'testing'])){
            $fastFoodCategoryId = ProductCategory::where('name', 'Fast Food')->first()->id;
            $noodlesCategoryId = ProductCategory::where('name', 'Noodles')->first()->id;
            $beverageCategoryId = ProductCategory::where('name', 'Beverage')->first()->id;
            $fastFoodStoreId = 1;
            $noodlesStoreId = 2;
            $beverageStoreId = 3;

            //products in store 1
            $product = Product::factory()->create([
                'name' => 'Hamburger',
                'description' => 'This is hamburger.',
                'store_id' => $fastFoodStoreId,
                'category_id' => $fastFoodCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of burger',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 2,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Meat',
                'description' => 'Meat of burger',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Pork',
                'extra_price' => 2,
            ]);

            $option->optionDetails()->create([
                'name' => 'Beef',
                'extra_price' => 3,
            ]);

            $product = Product::factory()->create([
                'name' => 'Cheeseburger',
                'description' => 'This is cheeseburger.',
                'store_id' => $fastFoodStoreId,
                'category_id' => $fastFoodCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of burger',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 3,
            ]);

            $product = Product::factory()->create([
                'name' => 'Little Hamburger',
                'description' => 'This is Little Hamburger.',
                'store_id' => $fastFoodStoreId,
                'category_id' => $fastFoodCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of burger',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 4,
            ]);

            $product = Product::factory()->create([
                'name' => 'Pasta',
                'description' => 'This is Pasta.',
                'store_id' => $fastFoodStoreId,
                'category_id' => $noodlesCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of pasta',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 5,
            ]);

            //products in store 2
            $product = Product::factory()->create([
                'name' => 'Penang Laksa',
                'description' => 'This is Penang laksa.',
                'store_id' => $noodlesStoreId,
                'category_id' => $noodlesCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of noodles',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 2,
            ]);

            $product = Product::factory()->create([
                'name' => 'Hokkien Mee',
                'description' => 'This is Hokkien mee.',
                'store_id' => $noodlesStoreId,
                'category_id' => $noodlesCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of noodles',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 3,
            ]);

            $product = Product::factory()->create([
                'name' => 'Char Kway Teow',
                'description' => 'This is Char Kway Teow.',
                'store_id' => $noodlesStoreId,
                'category_id' => $noodlesCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of noodles',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 4,
            ]);

            $product = Product::factory()->create([
                'name' => 'French Fries',
                'description' => 'This is french fries.',
                'store_id' => $noodlesStoreId,
                'category_id' => $fastFoodCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of french fries',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 5,
            ]);

            //products in store 3
            $product = Product::factory()->create([
                'name' => 'Coffee',
                'description' => 'This is coffee.',
                'store_id' => $beverageStoreId,
                'category_id' => $beverageCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of drinks',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 2,
            ]);

            $product = Product::factory()->create([
                'name' => 'Orange Juice',
                'description' => 'This is orange juice.',
                'store_id' => $beverageStoreId,
                'category_id' => $beverageCategoryId,
            ]);
            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of drinks',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 3,
            ]);

            $product = Product::factory()->create([
                'name' => 'Tea',
                'description' => 'This is tea.',
                'store_id' => $beverageStoreId,
                'category_id' => $beverageCategoryId,
            ]);

            $option = $product->productOptions()->create([
                'name' => 'Size',
                'description' => 'Size of drinks',
            ]);

            $option->optionDetails()->create([
                'name' => 'None',
                'extra_price' => 0,
            ]);

            $option->optionDetails()->create([
                'name' => 'Large',
                'extra_price' => 4,
            ]);
        }

    }
}
