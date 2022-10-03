<?php

namespace Database\Seeders;

use App\Models\POSSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class POSSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['key' => 'app_name', 'value' => 'Laravel-POS'],
            ['key' => 'currency_symbol', 'value' => '$'],
        ];

        foreach ($data as $value) {
            POSSetting::updateOrCreate([
                'key' => $value['key'],
                'value' => $value['value'],
            ]);
        }
    }
}
