<?php

namespace Database\Seeders;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    const MORNING_CLASS_REST_TIME = [
        1 => [
            1, 2, 3
        ],
        2 => [
            6, 7, 8
        ],
        3 => [
            11, 12, 13
        ], 
        4 => [
            16, 17, 18
        ],
        5 => [
            21, 22, 23
        ],
    ];

    const AFTERNOON_CLASS_REST_TIME = [
        1 => [
            4, 5
        ],
        2 => [
            9, 10
        ],
        3 => [
            14, 15
        ], 
        4 => [
            19, 20
        ],
        5 => [
            24, 25
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // sandbox student
        $student = Student::factory()->create([
            'username' => 'sandbox_student',
            'email' => 'sandbox_student@isp.com',
            'email_verified_at' => Carbon::now(),
            'is_a_sandbox_student' => true,
        ]);

        foreach(StudentSeeder::MORNING_CLASS_REST_TIME as $restTimes){
            $student->restTimes()->attach($restTimes);
        }

        // student1
        $student = Student::factory()->create([
            'username' => 'student1',
            'email' => 'student1@isp.com',
            'email_verified_at' => Carbon::now(),
        ]);

        foreach(StudentSeeder::MORNING_CLASS_REST_TIME as $restTimes){
            $student->restTimes()->attach($restTimes);
        }

        // student2
        $student = Student::factory()->create([
            'username' => 'student2',
            'email' => null,
            'email_verified_at' => null,
        ]);

        foreach(StudentSeeder::AFTERNOON_CLASS_REST_TIME as $restTimes){
            $student->restTimes()->attach($restTimes);
        }
    }
}
