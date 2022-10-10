<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService
{
    public function formatCurrency(int $priceInCent): string
    {
        return number_format($priceInCent / 100, 2, ',');
    }

    public function getAllProducts(): Collection
    {
        return $this->updateProductQuantities(Product::all());
    }

    /**
     * @param Collection $products
     *
     * checks if a product in the Collection consists of sevaral other products
     * if so sets the quantity to the lowest available
     * else quantity is taken from the product itself
     * eitherways a new Collection with updated quantities is returned
     *
     * @return Collection
     */
    public function updateProductQuantities(Collection $products): Collection
    {
        $products->map(function ($product) use ($products) {
            if ($product['product_list']) {
                $productList = json_decode($product['product_list']);
                if ($productList && count($productList) > 1) {
                    $quantities = [];
                    foreach ($productList as $productId) {
                        if ($products->find($productId)) {
                            $quantities[] = $products->find($productId)['quantity_available'];
                        }
                    }
                    if (!empty($quantities)) $product['quantity_available'] = min($quantities);
                }
            }

        });
        return $products;
    }
}