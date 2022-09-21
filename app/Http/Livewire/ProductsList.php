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
}