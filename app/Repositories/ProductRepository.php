<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    /**
     * @throws \Exception
     */
    public function getProduct(int $product_id): Product
    {
        // get product
        $product = Cache::get('product_' . $product_id);
        if (!$product) {
            // The product is not in the cache, retrieve it from the database
            $product = $this->findProduct($product_id);
            // Cache the product again
            Cache::put('product_' . $product->id, $product);
        }
        return $product;
    }

    public function findProduct(int $product_id): Product
    {
        $product = Product::with('ingredients')->find($product_id);
        if(!$product){
            throw new \Exception("this product is not exist");
        }
        if($product->ingredients->count() <= 0 ){
            throw new \Exception("this product is not allowed to be ordered");
        }
        return $product;
    }

}
