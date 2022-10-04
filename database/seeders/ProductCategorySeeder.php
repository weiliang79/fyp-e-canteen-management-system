<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(App::environment(['local', 'testing'])){
            ProductCategory::create([
                'name' => 'Fast Food',
                'Description' => 'This is fast food category.',
            ]);

            ProductCategory::create([
                'name' => 'Noodles',
                'Description' => 'This is noodles category.',
            ]);

            ProductCategory::create([
                'name' => 'Beverage',
                'Description' => 'This is beverage category.',
            ]);
        }

    }
}
