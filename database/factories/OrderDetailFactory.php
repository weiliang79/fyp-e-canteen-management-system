<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'notes' => $this->faker->sentence(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (OrderDetail $orderDetail) {
            $product = $this->getRandomProduct();
            $options = $this->getProductOptions($product);

            $orderDetail->product_id = $product->id;
            $orderDetail->product_options = $options['result'];
            $orderDetail->price = $product->price + $options['option_price'];
        })->afterCreating(function (OrderDetail $orderDetail) {
            $product = $this->getRandomProduct();
            $options = $this->getProductOptions($product);

            $orderDetail->product_id = $product->id;
            $orderDetail->product_options = $options['result'];
            $orderDetail->price = $product->price + $options['option_price'];
            $orderDetail->save();
        });
    }

    private function getRandomProduct(){
        return Product::inRandomOrder()->first();
    }

    public function getProductOptions(Product $product){
        $options = $product->productOptions;
        $result = array();
        $optionPrice = 0;

        foreach($options as $option){
            $detail = $option->optionDetails()->inRandomOrder()->first();
            array_push($result, [$option->id => $detail->id]);
            $optionPrice = $optionPrice + $detail->extra_price;
        }

        return [
            'result' => $result,
            'option_price' => $optionPrice,
        ];
    }
}
