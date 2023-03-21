<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ingredient>
 */
class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'full_stock' => fake()->randomFloat(2, 20000, 50000),
            'stock' => fake()->randomFloat(2, 2000, 50000),
            'threshold' => fake()->randomFloat(2, 50, 100),
        ];
    }
}
