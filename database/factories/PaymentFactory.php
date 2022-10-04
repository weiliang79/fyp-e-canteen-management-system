<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\PaymentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'payment_type_id' => $this->faker->numberBetween(PaymentType::PAYMENT_2C2P, PaymentType::PAYMENT_CASH),
            'status' => $this->faker->numberBetween(Payment::STATUS_PENDING, Payment::STATUS_SUCCESS),
        ];
    }
}
