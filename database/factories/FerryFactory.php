<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Ferry>
 */
class FerryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => ucfirst(fake()->unique()->firstName()),
            'length' => fake()->randomFloat(1, 20, 120),
            'width' => fake()->randomFloat(1, 5, 25),
            'speed' => fake()->numberBetween(10, 30),
            'capacity' => 0,
        ];
    }
}
