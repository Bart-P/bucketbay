<?php

namespace App\Http\Livewire;

use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductsList extends Component
{
    protected CartService $cartService;
    protected ProductService $productService;

    public function boot(CartService $cartService, ProductService $productService)
    {
        $this->cartService = $cartService;
        $this->productService = $productService;
    }

    public function render(): Factory|View|Application
    {
        $products = $this->productService->getAllProducts();
        return view('livewire.products-list', ['items' => $products]);
    }

    public function addOneProductToCart(int $id, int $priceInCent): void
    {
        $this->cartService->addProduct($id, $priceInCent);
    }

    public function removeProductFromCart($id): void
    {
        $this->cartService->removeProductFromCart($id);
    }

    public function productIdIsSetInCart(int $id): bool
    {
        return $this->cartService->productIdIsSet($id);
    }

    public function getProductQuantityFromCart(int $id): int
    {
        return $this->cartService->getQuantityInCart($id);
    }

    public function formatCurrency(int $priceInCent): string
    {
        return $this->productService->formatCurrency($priceInCent);
    }
}