<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'username' => 'admin1',
            'role_id' => Role::ROLE_ADMIN,
            'email' => 'admin@isp.com',
            'email_verified_at' => Carbon::now(),
        ]);

        // admin without email verified
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'username' => 'admin2',
            'role_id' => Role::ROLE_ADMIN,
            'email' => null,
            'email_verified_at' => null,
        ]);

        // food seller 1
        $user = User::factory()->create([
            'first_name' => 'Food',
            'last_name' => 'Seller',
            'username' => 'foodseller1',
            'role_id' => Role::ROLE_SELLER,
            'email' => 'foodseller1@isp.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $user->store()->create([
            'name' => 'Test Store 1',
            'description' => 'This is test store 1.',
        ]);

        // food seller 2
        $user = User::factory()->create([
            'first_name' => 'Food',
            'last_name' => 'Seller',
            'username' => 'foodseller2',
            'role_id' => Role::ROLE_SELLER,
            'email' => 'foodseller2@isp.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $user->store()->create([
            'name' => 'Test Store 2',
            'description' => 'This is test store 2.',
        ]);

        // food seller 3
        $user = User::factory()->create([
            'first_name' => 'Food',
            'last_name' => 'Seller',
            'username' => 'foodseller3',
            'role_id' => Role::ROLE_SELLER,
            'email' => 'foodseller3@isp.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $user->store()->create([
            'name' => 'Test Store 3',
            'description' => 'This is test store 3.',
        ]);

        // food seller 4
        User::factory()->create([
            'first_name' => 'Food',
            'last_name' => 'Seller',
            'username' => 'foodseller4',
            'role_id' => Role::ROLE_SELLER,
            'email' => null,
            'email_verified_at' => null,
        ]);
    }
}
