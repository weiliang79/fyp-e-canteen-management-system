<?php

namespace Database\Seeders;

use App\Models\InformationPageDesign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformationDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InformationPageDesign::create([
            'title' => 'About Us',
            'content' => '<p>This is About Us page.</p>'
        ]);

        InformationPageDesign::create([
            'title' => 'Contact Us',
            'content' => '<p>This is Contact Us page.</p>'
        ]);
    }
}
