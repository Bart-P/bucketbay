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
    public function definition(): array
    {
        return ['user_id'    => User::all()->random()->id,
                'name'       => $this->faker->unique()->company,
                'file'       => 'placeholder_150x100.png',
                'type'       => 'png',
                'size_in_mb' => $this->faker->randomFloat(2, 0.1, 5),];
    }
}