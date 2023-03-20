<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Ingredient;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some products
        $products = [
            [
                'name' => 'burger',
                'price' => 5.99,
            ],
            [
                'name' => 'Cheeseburger',
                'price' => 6.99,
            ],

        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Attach ingredients to the product
            $ingredients = [
                [
                    'name' => 'Beef',
                    'stock' => 20000,
                    'threshold' => 50,
                    'quantity' => 150,
                ],
                [
                    'name' => 'Cheese',
                    'stock' => 5000,
                    'threshold' => 50,
                    'quantity' => 30,
                ],
                [
                    'name' => 'Onion',
                    'stock' => 1000,
                    'threshold' => 50,
                    'quantity' => 20,
                ],
             ];

            foreach ($ingredients as $ingredientData) {
                $ingredient = Ingredient::create([
                    'name' => $ingredientData['name'],
                    'full_stock' => $ingredientData['stock'],
                    'stock' => $ingredientData['stock'],
                    'threshold' => $ingredientData['threshold'],
                ]);
                $product->ingredients()->attach($ingredient, ['quantity' => $ingredientData['quantity']]);
            }
        }
    }
}
