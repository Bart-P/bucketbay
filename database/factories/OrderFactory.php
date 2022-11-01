<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $status = OrderStatusEnum::cases()[array_rand(OrderStatusEnum::cases())];

        return [
            'user_id'                => 1,
            'status'                 => $status,
            'delivery_address_id'    => Address::whereUserId(1)->get()->random()->id,
            'print_price_in_cent'    => 599,
            'shipment_price_in_cent' => 999,
            'sent_at'                => $status == OrderStatusEnum::OPEN ? null : $this->faker->dateTimeBetween('-3 months', '-1 days'),
        ];
    }
}