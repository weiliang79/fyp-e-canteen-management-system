<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /* \App\Models\User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'TestUser',
            'email' => 'test@example.com',
        ]);*/

        $this->call([
            RoleSeeder::class, 
            UserSeeder::class, 
            RestTimeSeeder::class, 
            StudentSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            PaymentTypeSeeder::class,
        ]);
    }
}
