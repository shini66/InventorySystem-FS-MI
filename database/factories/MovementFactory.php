<?php

namespace Database\Factories;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movement>
 */
class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['entry', 'exit']),
            'quantity' => fake()->numberBetween(1, 50),
            'product_id' => Product::factory(),
            'supplier' => null,
            'reason' => null,
            'date' => fake()->dateTime(),
        ];
    }

    public function entry(): static
    {
        return $this->state(fn () => [
            'type' => 'entry',
            'supplier' => fake()->company(),
        ]);
    }

    public function exit(): static
    {
        return $this->state(fn () => [
            'type' => 'exit',
            'reason' => fake()->sentence(),
        ]);
    }
}
