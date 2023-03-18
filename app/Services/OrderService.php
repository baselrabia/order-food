<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\IngredientRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private OrderRepository $orderRepo;
    private ProductRepository $productRepo;
    private IngredientRepository $ingredientRepo;

    public function __construct(OrderRepository $orderRepo, ProductRepository $productRepo, IngredientRepository $ingredientRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->ingredientRepo = $ingredientRepo;
    }

    /**
     * @throws \Exception
     */
    public function createOrder(array $data): Order
    {
        $trans = DB::beginTransaction();
        try {
            $products = $data["products"];

            $this->updateStock($products);

            $order = $this->orderRepo->create($products);

            DB::commit($trans);
            return $order;
        } catch (\Exception $e) {
            Log::error('createOrder() ERROR: ' . $e->getMessage(), $data);
            DB::rollBack($trans);
            throw $e;
        }
    }


    /**
     * @throws \Exception
     */
    public function updateStock(array $products): void
    {
        // Calculate the total quantity required for each ingredient in the order
        $ingredientsQuantities = [];
        foreach ($products as $productData) {

            $product_id = $productData['product_id'];
            $product = $this->productRepo->getProduct($product_id);

            foreach ($product->ingredients as $ingredientData) {
                $ingredient_id = $ingredientData['id'];
                $quantity = $ingredientData->pivot->quantity * $productData['quantity'];

                if (isset($ingredientsQuantities[$ingredient_id])) {
                    $ingredientsQuantities[$ingredient_id] += $quantity;
                } else {
                    $ingredientsQuantities[$ingredient_id] = $quantity;
                }
            }
        }

        // Update the stock of each ingredient in the database
        foreach ($ingredientsQuantities as $ingredient_id => $quantity) {
            $this->ingredientRepo->updateIngredientStock($ingredient_id, $quantity);
        }
    }


}
