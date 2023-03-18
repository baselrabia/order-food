<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    public function getProduct(int $product_id): Product
    {
        // get product
        $product = Cache::get('product_' . $product_id);
        if (!$product) {
            // The product is not in the cache, retrieve it from the database
            $product = Product::with('ingredients')->find($product_id);
            if(!$product){
                throw new \Exception("this product is not exist");
            }
            // Cache the product again
            Cache::put('product_' . $product->id, $product);
        }
        return $product;
    }

}
