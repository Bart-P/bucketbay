<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductsList extends Component
{
    protected CartService $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products-list', ['items' => Product::all()]);
    }

    public function addOneProductToCart($id): void
    {
        $this->cartService->addProduct($id);
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
        return number_format($priceInCent / 100, 2, ',');
    }
}