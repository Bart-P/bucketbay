<?php

namespace Database\Factories;

use App\Models\Grafic;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderObjectFactory extends Factory
{
    public function definition(): array
    {
        $products = Product::get(['id', 'price_in_cent']);
        $productId = $this->faker->randomElement($products->pluck('id')->toArray());
        if ($productId === 1) $productId = 2;
        $productPrice = $products[$productId - 1]['price_in_cent'];
        $grafics = $this->faker->boolean() && $productId != 4 ? [$this->faker->randomElement(Grafic::get('id')->values())->id] : [];
        if (!empty($grafics) && count($grafics) && $this->faker->boolean()) {
            $grafics[] = $this->faker->randomElement(Grafic::get('id')->values())->id;
        };
        return ['order_id'      => $this->faker->randomElement(Order::get('id')->values()),
                'product_id'    => $productId,
                'product_price' => $productPrice,
                'grafics'       => json_encode($grafics),
                'quantity'      => $this->faker->numberBetween(1, 15),];
    }
}