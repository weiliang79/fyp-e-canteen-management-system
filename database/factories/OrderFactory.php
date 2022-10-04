<?php

namespace Database\Factories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $startDate = Carbon::createFromTimestamp($this->faker->dateTimeBetween('-1 year', '+1 year')->getTimestamp());
        return [
            'pick_up_start' =>$startDate->getTimestamp(),
            'pick_up_end' => $startDate->addMinutes(20)->getTimestamp(),
            'status' => $this->faker->numberBetween(Order::PAYMENT_PENDING, Order::PAYMENT_SUCCESS),
        ];
    }
}
