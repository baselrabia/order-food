<?php

namespace App\Observers;

use App\Mail\IngredientThresholdReached;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Mail;

class IngredientObserver
{

    /**
     * Handle the Ingredient "updated" event.
     */
    public function updated(Ingredient $ingredient): void
    {
        $ingredient_threshold = ($ingredient->full_stock * $ingredient->threshold) / 100;
        if ($ingredient->stock < $ingredient_threshold && !$ingredient->notification_sent) {
            // send email to the merchant
            Mail::to('merchent@example.com')->queue(new IngredientThresholdReached($ingredient));
            $ingredient->notification_sent = true;
            $ingredient->save();
        }
    }
}
