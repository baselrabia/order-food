<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class OrderService
{

    public function __construct()
    {
    }

    public function createOrder(array $data): Order
    {
        $productData = $data["products"][0];
        $product_id = $productData['product_id'];
        // get product
        $product = Cache::get('product_' . $product_id);
        if (!$product) {
            // The product is not in the cache, retrieve it from the database
            $product = Product::with('ingredients')->find($product_id);
             // Cache the product again
            Cache::put('product_' . $product->id, $product);
        }


        // Create the order
        $order = new Order();
        $order->product_id  = $product->id;
        $order->quantity    = $productData['quantity'];
        $order->total       = $productData['quantity'] * $product->price;
        $order->save();

        return $order;
    }
}
