<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductsInCart extends Component
{
    public array $newProductQuantities = [];
    private CartService $cartService;

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
        $this->newProductQuantities = $this->cartService->getProducts()->toArray();
    }

    public function render(): Factory|View|Application
    {
        $productsInCart = $this->cartService->getProducts();
        return view('livewire.products-in-cart', ['products' => Product::find($productsInCart->keys())]);
    }

    public function deleteProductFromCart($id): void
    {
        $this->cartService->removeProduct($id);
    }

    public function addProductToOrderObjects($productId)
    {
        $orderObject = $this->cartService->createOrderObject($productId, [], 1);
        $this->cartService->addOrderObject($orderObject);
        $this->emit('orderObjectsChanged');
    }
}