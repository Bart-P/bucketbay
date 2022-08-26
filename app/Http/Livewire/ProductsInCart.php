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
    private CartService $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function render(): Factory|View|Application
    {
        $productsInCart = $this->cartService->getProducts();
        return view('livewire.products-in-cart', ['products'       => Product::find($productsInCart->keys()),
                                                  'productsInCart' => $productsInCart]);
    }
}