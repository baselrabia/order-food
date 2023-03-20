<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\Product\ProductRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    private ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
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
