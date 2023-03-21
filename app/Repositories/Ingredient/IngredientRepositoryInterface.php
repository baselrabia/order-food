<?php

namespace App\Repositories\Ingredient;

interface IngredientRepositoryInterface
{
    public function updateIngredientStock(int|string $ingredient_id, mixed $quantity): void;
}
