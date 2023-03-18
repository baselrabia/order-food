<?php

namespace Tests\Unit;

use App\Models\Ingredient;
use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
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
    private $orderService;

    /**
     * A basic test example.
     */
    public function test_order_creation(): void
    {
        $order = $this->orderService->createOrder($this->payload);
        $productIds = $order->products()->pluck('product_id')->toArray();

        $this->assertContains($this->payload["products"][0]['product_id'], $productIds);
    }

    /**
     * A basic test example.
     */
    public function test_stock_is_updated_after_order(): void
    {

        $order = $this->orderService->createOrder($this->payload);
        $beef_stock = Ingredient::where('id',$this->beef->id)->first()->stock;

        $this->assertEquals($this->beef->stock - 300, $beef_stock);
    }

    /**
     * A basic test example.
     */
    public function test_stock_is_not_enough_for_order(): void
    {
        $payload = [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 2000,
                ]
            ]
        ];

        $this->expectExceptionMessage("The current ingredient stock is insufficient to fulfill the order quantity");
        $order = $this->orderService->createOrder($payload);
     }



    protected function setUp(): void
    {
        parent::setUp();

        // Create product
        $this->product = Product::factory()->create(['name' => 'Burger', 'price' => 6]);

        // Create ingredients and associate them with the product
        $this->beef = Ingredient::factory()->create([
            'name' => 'Beef',
            'full_stock' => 20000,
            'stock' => 20000,
            'threshold' => 50
        ]);
        $this->cheese = Ingredient::factory()->create([
            'name' => 'Cheese',
            'full_stock' => 5000,
            'stock' => 5000,
            'threshold' => 50
        ]);
        $this->onion = Ingredient::factory()->create([
            'name' => 'Onion',
            'full_stock' => 1000,
            'stock' => 1000,
            'threshold' => 50
        ]);

        $this->product->ingredients()->attach([
            $this->beef->id => ['quantity' => 150],
            $this->cheese->id => ['quantity' => 30],
            $this->onion->id => ['quantity' => 20],
        ]);

        $this->orderService = $this->app->get(OrderService::class);

        $this->payload = [
            "products" => [
                [
                    "product_id" => 1,
                    "quantity" => 2,
                ]
            ]
        ];
    }
}
