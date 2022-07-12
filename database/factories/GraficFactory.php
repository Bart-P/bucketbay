<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grafic>
 */
class GraficFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
      'name' => $this->faker->text(5) . ' logo',
      'file' => 'placeholder_150x100.png',
      'type' => $this->faker->text(10),
      'user_id' => User::all()->random()->id,
    ];
    }
}
