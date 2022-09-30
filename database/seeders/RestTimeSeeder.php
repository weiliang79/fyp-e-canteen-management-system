<?php

namespace Database\Seeders;

use App\Models\RestTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Monday rest time
        // Morning classes
        RestTime::create([
            'day_id' => 1,
            'start_time' => '6:00 AM',
            'end_time' => '7:10 AM',
            'description' => 'Rest time for morning classes before class start in Monday.',
        ]);

        RestTime::create([
            'day_id' => 1,
            'start_time' => '10:00 AM',
            'end_time' => '10:20 AM',
            'description' => 'Rest time for morning classes in Monday.',
        ]);

        RestTime::create([
            'day_id' => 1,
            'start_time' => '1:00 PM',
            'end_time' => '6:00 PM',
            'description' => 'Rest time for morning classes after class end in Monday.',
        ]);

        // Afternoon classes
        RestTime::create([
            'day_id' => 1,
            'start_time' => '6:00 AM',
            'end_time' => '1:00 PM',
            'description' => 'Rest time for afternoon classes before class start in Monday.',
        ]);

        RestTime::create([
            'day_id' => 1,
            'start_time' => '3:00 PM',
            'end_time' => '3:20 PM',
            'description' => 'Rest time for afternoon classes in Monday.',
        ]);

        // Tuesday rest time
        // Morning classes
        RestTime::create([
            'day_id' => 2,
            'start_time' => '6:00 AM',
            'end_time' => '7:10 AM',
            'description' => 'Rest time for morning classes before class start in Tuesday.',
        ]);

        RestTime::create([
            'day_id' => 2,
            'start_time' => '10:00 AM',
            'end_time' => '10:20 AM',
            'description' => 'Rest time for morning classes in Tuesday.',
        ]);

        RestTime::create([
            'day_id' => 2,
            'start_time' => '1:00 PM',
            'end_time' => '6:00 PM',
            'description' => 'Rest time for morning classes after class end in Tuesday.',
        ]);

        // Afternoon classes
        RestTime::create([
            'day_id' => 2,
            'start_time' => '6:00 AM',
            'end_time' => '1:00 PM',
            'description' => 'Rest time for afternoon classes before class start in Tuesday.',
        ]);

        RestTime::create([
            'day_id' => 2,
            'start_time' => '3:00 PM',
            'end_time' => '3:20 PM',
            'description' => 'Rest time for afternoon classes in Tuesday.',
        ]);

        // Wednesday rest time
        // Morning classes
        RestTime::create([
            'day_id' => 3,
            'start_time' => '6:00 AM',
            'end_time' => '7:10 AM',
            'description' => 'Rest time for morning classes before class start in Wednesday.',
        ]);

        RestTime::create([
            'day_id' => 3,
            'start_time' => '10:00 AM',
            'end_time' => '10:20 AM',
            'description' => 'Rest time for morning classes in Wednesday.',
        ]);

        RestTime::create([
            'day_id' => 1,
            'start_time' => '1:00 PM',
            'end_time' => '6:00 PM',
            'description' => 'Rest time for morning classes after class end in Wednesday.',
        ]);

        // Afternoon classes
        RestTime::create([
            'day_id' => 3,
            'start_time' => '6:00 AM',
            'end_time' => '1:00 PM',
            'description' => 'Rest time for afternoon classes before class start in Wednesday.',
        ]);

        RestTime::create([
            'day_id' => 3,
            'start_time' => '3:00 PM',
            'end_time' => '3:20 PM',
            'description' => 'Rest time for afternoon classes in Wednesday.',
        ]);

        // Thursday rest time
        // Morning classes
        RestTime::create([
            'day_id' => 4,
            'start_time' => '6:00 AM',
            'end_time' => '7:10 AM',
            'description' => 'Rest time for morning classes before class start in Thursday.',
        ]);

        RestTime::create([
            'day_id' => 4,
            'start_time' => '10:00 AM',
            'end_time' => '10:20 AM',
            'description' => 'Rest time for morning classes in Thursday.',
        ]);

        RestTime::create([
            'day_id' => 4,
            'start_time' => '1:00 PM',
            'end_time' => '6:00 PM',
            'description' => 'Rest time for morning classes after class end in Thursday.',
        ]);

        // Afternoon classes
        RestTime::create([
            'day_id' => 4,
            'start_time' => '6:00 AM',
            'end_time' => '1:00 PM',
            'description' => 'Rest time for afternoon classes before class start in Thursday.',
        ]);

        RestTime::create([
            'day_id' => 4,
            'start_time' => '3:00 PM',
            'end_time' => '3:20 PM',
            'description' => 'Rest time for afternoon classes in Thursday.',
        ]);

        // Friday rest time
        // Morning classes
        RestTime::create([
            'day_id' => 5,
            'start_time' => '6:00 AM',
            'end_time' => '7:10 AM',
            'description' => 'Rest time for morning classes before class start in Friday.',
        ]);

        RestTime::create([
            'day_id' => 5,
            'start_time' => '10:00 AM',
            'end_time' => '10:20 AM',
            'description' => 'Rest time for morning classes in Friday.',
        ]);

        RestTime::create([
            'day_id' => 5,
            'start_time' => '1:00 PM',
            'end_time' => '6:00 PM',
            'description' => 'Rest time for morning classes after class end in Friday.',
        ]);

        // Afternoon classes
        RestTime::create([
            'day_id' => 5,
            'start_time' => '6:00 AM',
            'end_time' => '1:00 PM',
            'description' => 'Rest time for afternoon classes before class start in Friday.',
        ]);

        RestTime::create([
            'day_id' => 5,
            'start_time' => '3:00 PM',
            'end_time' => '3:20 PM',
            'description' => 'Rest time for afternoon classes in Friday.',
        ]);
    }
}
