<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Ingredient;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a valid order request.
     *
     * @return void
     */
    public function testValidOrderRequest()
    {
        // Create a test product
        $product = Product::factory()->create();

        // Create test ingredients
        $beef = Ingredient::factory()->create(['name' => 'Beef', 'stock' => 20000]);
        $product->ingredients()->attach($beef, ['quantity' => 150]);

        $cheese = Ingredient::factory()->create(['name' => 'Cheese', 'stock' => 5000]);
        $product->ingredients()->attach($cheese, ['quantity' => 30]);

        $onion = Ingredient::factory()->create(['name' => 'Onion', 'stock' => 1000]);
        $product->ingredients()->attach($onion, ['quantity' => 20]);


        // Create the order payload
        $order = [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ]
            ]
        ];

        // Send the order request
        $response = $this->postJson('/api/orders', $order);

        // Assert the response is correct
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Order successfully created',
        ]);

        // Assert the order was stored in the database
        $this->assertDatabaseHas('order_product', [
            'order_id' => 1,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // Assert the ingredient stock levels were updated
        $this->assertDatabaseHas('ingredients', [
            'name' => 'Beef',
            'stock' => 19700,
        ]);
        $this->assertDatabaseHas('ingredients', [
            'name' => 'Cheese',
            'stock' => 4940,
        ]);
        $this->assertDatabaseHas('ingredients', [
            'name' => 'Onion',
            'stock' => 960,
        ]);
    }

    /**
     * Test an invalid order request with missing product ID.
     *
     * @return void
     */
    public function testInvalidOrderRequestMissingProductId()
    {
        $order = [
            'products' => [
                [
                    'quantity' => 2,
                ]
            ]
        ];

        $response = $this->postJson('/api/orders', $order);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['products.0.product_id']);
    }

    /**
     * Test an invalid order request with negative quantity.
     *
     * @return void
     */
    public function testInvalidOrderRequestNegativeQuantity()
    {
         $product = Product::factory()->create();

        $order = [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => -1,
                ]
            ]
        ];

        $response = $this->postJson('/api/orders', $order);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['products.0.quantity']);
    }

}
