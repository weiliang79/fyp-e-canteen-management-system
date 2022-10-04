<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(App::environment('local')){

            $student = Student::where('is_a_sandbox_student', true)->first();

            for ($i = 0; $i < 3; $i++){
                $order = \App\Models\Order::factory()
                    ->has(
                        \App\Models\OrderDetail::factory()
                            ->count(3)
                            ->state(function (array $attributes, \App\Models\Order $order) {
                                return ['order_id' => $order->id];
                            })
                    )
                    ->has(
                        \App\Models\Payment::factory()
                            ->state(function (array $attributes, \App\Models\Order $order) {
                                return ['order_id' => $order->id, 'amount' => $order->total_price];
                            })
                    )
                    ->create([
                        'student_id' => $student->id,
                        'total_price' => 0,
                        'is_sandbox_order' => true,
                    ]);

                $order->total_price = $order->orderDetails()->sum('price');
                $order->save();

                foreach($order->payments as $payment){
                    $payment->amount = $order->total_price;
                    $payment->save();
                }
            }

        } else if(App::environment('testing')){

        }


    }
}
