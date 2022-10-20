<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Student;
use Carbon\Carbon;
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

            $this->command->info('Generating orders within 3 years, please wait a while...');

            $student1 = Student::where('username', 'student1')->first();
            $student2 = Student::where('username', 'student2')->first();
            $student3 = Student::where('username', 'student3')->first();

            $start = Carbon::today()->addYears(-3)->startOfMonth();
            $end = Carbon::today()->startOfMonth();

            while($start->lte($end)){

                $this->command->info('Generating orders in ' . $start->format('Y F'));

                for($i = 0; $i < 10; $i++){
                    $temp = $start->copy();
                    $temp->addDays(rand(0, 27));

                    // student 1
                    $order = \App\Models\Order::factory()
                        ->has(
                            \App\Models\OrderDetail::factory()
                                ->count(3)
                                ->state(function (array $attributes, \App\Models\Order $order) use ($temp) {
                                    return [
                                        'order_id' => $order->id,
                                        'is_pickup' => (boolean)random_int(0, 1),
                                        'created_at' => $temp,
                                        'updated_at' => $temp,
                                    ];
                                })
                        )
                        ->has(
                            \App\Models\Payment::factory()
                                ->state(function (array $attributes, \App\Models\Order $order) use ($temp) {
                                    return [
                                        'order_id' => $order->id,
                                        'amount' => $order->total_price,
                                        'status' => \App\Models\Payment::STATUS_SUCCESS,
                                        'created_at' => $temp,
                                        'updated_at' => $temp,
                                    ];
                                })
                        )
                        ->create([
                            'student_id' => $student1->id,
                            'total_price' => 0,
                            'status' => Order::PAYMENT_SUCCESS,
                            'is_sandbox_order' => $student1->is_a_sandbox_student,
                            'created_at' => $temp,
                            'updated_at' => $temp,
                        ]);

                    $order->total_price = $order->orderDetails()->sum('price');
                    $order->status = $order->orderDetails()->where('is_pickup', false)->count() > 0 ? Order::PICKUP_PARTIALLY : Order::PICKUP_ALL;
                    $order->save();

                    foreach($order->payments as $payment){
                        $payment->amount = $order->total_price;
                        $payment->save();
                    }

                    // student 2
                    $order = \App\Models\Order::factory()
                        ->has(
                            \App\Models\OrderDetail::factory()
                                ->count(3)
                                ->state(function (array $attributes, \App\Models\Order $order) use ($temp) {
                                    return [
                                        'order_id' => $order->id,
                                        'is_pickup' => (boolean)random_int(0, 1),
                                        'created_at' => $temp,
                                        'updated_at' => $temp,
                                    ];
                                })
                        )
                        ->has(
                            \App\Models\Payment::factory()
                                ->state(function (array $attributes, \App\Models\Order $order) use ($temp) {
                                    return [
                                        'order_id' => $order->id,
                                        'amount' => $order->total_price,
                                        'status' => \App\Models\Payment::STATUS_SUCCESS,
                                        'created_at' => $temp,
                                        'updated_at' => $temp,
                                    ];
                                })
                        )
                        ->create([
                            'student_id' => $student2->id,
                            'total_price' => 0,
                            'status' => Order::PAYMENT_SUCCESS,
                            'is_sandbox_order' => $student2->is_a_sandbox_student,
                            'created_at' => $temp,
                            'updated_at' => $temp,
                        ]);

                    $order->total_price = $order->orderDetails()->sum('price');
                    $order->status = $order->orderDetails()->where('is_pickup', false)->count() > 0 ? Order::PICKUP_PARTIALLY : Order::PICKUP_ALL;
                    $order->save();

                    foreach($order->payments as $payment){
                        $payment->amount = $order->total_price;
                        $payment->save();
                    }

                    // student 3
                    $order = \App\Models\Order::factory()
                        ->has(
                            \App\Models\OrderDetail::factory()
                                ->count(3)
                                ->state(function (array $attributes, \App\Models\Order $order) use ($temp) {
                                    return [
                                        'order_id' => $order->id,
                                        'is_pickup' => (boolean)random_int(0, 1),
                                        'created_at' => $temp,
                                        'updated_at' => $temp,
                                    ];
                                })
                        )
                        ->has(
                            \App\Models\Payment::factory()
                                ->state(function (array $attributes, \App\Models\Order $order) use ($temp) {
                                    return [
                                        'order_id' => $order->id,
                                        'amount' => $order->total_price,
                                        'status' => \App\Models\Payment::STATUS_SUCCESS,
                                        'created_at' => $temp,
                                        'updated_at' => $temp,
                                    ];
                                })
                        )
                        ->create([
                            'student_id' => $student3->id,
                            'total_price' => 0,
                            'status' => Order::PAYMENT_SUCCESS,
                            'is_sandbox_order' => $student3->is_a_sandbox_student,
                            'created_at' => $temp,
                            'updated_at' => $temp,
                        ]);

                    $order->total_price = $order->orderDetails()->sum('price');
                    $order->status = $order->orderDetails()->where('is_pickup', false)->count() > 0 ? Order::PICKUP_PARTIALLY : Order::PICKUP_ALL;
                    $order->save();

                    foreach($order->payments as $payment){
                        $payment->amount = $order->total_price;
                        $payment->save();
                    }

                }

                $start->addMonth();
            }

            $this->command->info('Orders generate completed.');

        }

    }
}
