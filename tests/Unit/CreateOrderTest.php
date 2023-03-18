<?php

namespace Tests\Unit;

use App\Models\Ingredient;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithFaker;

    private mixed $beef;
    private mixed $cheese;
    private mixed $onion;
    private mixed $product;
    private array $payload;


    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
//        // Create product
//        $this->product = Product::factory()->create(['name' => 'Burger', 'price' => 6]);
//
//        // Create ingredients and associate them with the product
//        $this->beef = Ingredient::factory()->create(['name' => 'Beef', 'stock' => 20, 'threshold' => 50]);
//        $this->cheese = Ingredient::factory()->create(['name' => 'Cheese', 'stock' => 5, 'threshold' => 50]);
//        $this->onion = Ingredient::factory()->create(['name' => 'Onion', 'stock' => 1, 'threshold' => 50]);
//
//        $this->product->ingredients()->attach([
//            $this->beef->id => ['quantity' => 150],
//            $this->cheese->id => ['quantity' => 30],
//            $this->onion->id => ['quantity' => 20],
//        ]);

        $this->payload = [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 2,
                ]
            ]
        ];
    }
    /**
     * A basic test example.
     */
    public function test_create_order(): void
    {

        $orderService = new OrderService();

        $order = $orderService->createOrder($this->payload);



        $this->assertEquals($order->product_id ,$this->payload["products"][0]['product_id']);
    }
}
