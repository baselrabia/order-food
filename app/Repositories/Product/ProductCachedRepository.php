<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Cache;

class ProductCachedRepository implements ProductRepositoryInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository =$productRepository;
    }

    /**
     * @throws Exception
     */
    public function getProduct(int $product_id): Product
    {
        // get product
        $product = Cache::get('product_' . $product_id);
        if (!$product) {
            // The product is not in the cache, retrieve it from the database
            $product = $this->productRepository->getProduct($product_id);
            // Cache the product again
            Cache::put('product_' . $product->id, $product);
        }
        return $product;
    }



}
