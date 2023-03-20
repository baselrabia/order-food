<?php

namespace App\Repositories\Product;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getProduct(int $product_id): Product;
}
