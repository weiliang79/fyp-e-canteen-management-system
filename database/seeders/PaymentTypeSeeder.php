<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'name' => '2C2P',
            'description' => 'This is 2C2P payment method.',
        ]);

        PaymentType::create([
            'name' => 'Stripe',
            'description' => 'This is Stripe payment method.',
        ]);

        PaymentType::create([
            'name' => 'Cash',
            'description' => 'This is Cash payment method.',
        ]);
    }
}
