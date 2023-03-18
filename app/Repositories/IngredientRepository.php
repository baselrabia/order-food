<?php

namespace App\Repositories;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;

class IngredientRepository
{
    public function updateIngredientStock(int|string $ingredient_id, mixed $quantity): void
    {
        $ingredient = Ingredient::find($ingredient_id);
        if (!$ingredient) {
            throw new \Exception("this Ingredient is not exist with id " . $ingredient_id);
        }

        if ($ingredient->stock < $quantity) {
            Log::error('updateIngredientStock() Quantity needed : ' . $quantity . 'Stock is : ' . $ingredient->stock );
            throw new \Exception("The current ingredient stock is insufficient to fulfill the order quantity");
        }
        $ingredient->stock -= $quantity;
        $ingredient->save();
    }
}

