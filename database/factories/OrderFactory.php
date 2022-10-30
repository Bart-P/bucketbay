<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return ['status'              => OrderStatusEnum::cases()[array_rand(OrderStatusEnum::cases())],
                'delivery_address_id' => Address::all()->random()->id,
                'sent_at'             => $this->faker->date(),];
    }
}