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
        $products->map(function ($product) {
            if (isset($product['product_list']) && (!isset($product['quantity_available']) || $product['quantity_available'] === 0)) {
                $productList = json_decode($product['product_list']);
                if (count($productList) > 0) {
                    $quantities = Product::find($productList, ['quantity_available'])->pluck('quantity_available')->toArray();
                    $product['quantity_available'] = min($quantities);
                }
            }
        });
        return $products;
    }

    public function getPriceForPrint(): int
    {
        return Product::find(1, ['price_in_cent'])['price_in_cent'];
    }


}