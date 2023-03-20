<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Exception;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function getProduct(int $product_id): Product
    {
        $product = Product::with('ingredients')->find($product_id);
        if (!$product) {
            throw new Exception("this product is not exist");
        }
        if ($product->ingredients()->count() <= 0) {
            throw new Exception("this product is not allowed to be ordered");
        }
        return $product;
    }

}
