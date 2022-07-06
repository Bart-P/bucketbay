<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    return [
      'name1' => $this->faker->name(),
      'name2' => $this->faker->text(10),
      'name3' => $this->faker->text(5),
      'street' => $this->faker->streetAddress(),
      'street_nr' => $this->faker->buildingNumber(),
      'city' => $this->faker->city(),
      'city_code' => $this->faker->randomNumber(5, true),
      'country' => $this->faker->country(),
      'address_info' => $this->faker->text(15),
      'user_id' => $this->faker->unique()->randomNumber(7, true),
    ];
  }
}
