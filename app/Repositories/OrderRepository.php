<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    private ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function create(array $products): Order
    {
        $total = 0;
        $order = new Order();
        $order->save();

        foreach ($products as $productData) {
            $product_id = $productData['product_id'];
            $product = $this->productRepo->getProduct($product_id);
            $quantity = $productData['quantity'];
            $subtotal = $quantity * $product->price;
            $total += $subtotal;

            $order->products()->attach($product, [
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);
        }

        $order->total = $total;
        $order->save();

        return $order;
    }
}
