<?php

namespace App\Repositories;

use App\Mail\IngredientThresholdReached;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class IngredientRepository
{
        public function updateIngredientStock(int|string $ingredient_id, mixed $quantity): void
        {
            $ingredient = Ingredient::find($ingredient_id);
            if (!$ingredient) {
                throw new \Exception("this Ingredient is not exist with id " . $ingredient_id);
            }

            if ($ingredient->stock < $quantity) {
                Log::error('updateIngredientStock() for ' . $ingredient->name .
                    ' Quantity needed : ' . $quantity . ' Stock is : ' . $ingredient->stock);
                throw new \Exception("The current ingredient stock is insufficient to fulfill the order quantity");
            }
            $ingredient->stock -= $quantity;
            $ingredient->save();

            $ingredient_threshold = $ingredient->full_stock * $ingredient->threshold;
            if ($ingredient->stock < $ingredient_threshold && !$ingredient->notification_sent) {
                // send email to the merchant
                Mail::to('merchent@example.com')->queue(new IngredientThresholdReached($ingredient));
                $ingredient->notification_sent = true;
                $ingredient->save();
            }
        }
}

