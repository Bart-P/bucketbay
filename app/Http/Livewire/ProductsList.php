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
        $this->cartService->addOneProduct($id);
    }

    public function removeOneProductFromCart($id): void
    {
        $this->cartService->removeOneProduct($id);
    }

    public function getQuantityOfProductInCart($id): int
    {
        return $this->cartService->getQuantity($id);
    }
}