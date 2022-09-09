<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderObjectTable extends Component
{
    protected $listeners = ['orderObjectsChanged' => 'render'];
    private CartService $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function render(): Factory|View|Application
    {
        $productsInCart = Product::findMany($this->cartService->getProducts()->keys());
        $productsWithQuantitiesInCart = [];
        $cartData = ['products'     => $productsInCart,
                     'inCart'       => $productsWithQuantitiesInCart,
                     'orderObjects' => $this->cartService->getOrderObjects()];
        return view('livewire.order-object-table', $cartData);
    }

    public function getGraficPath(int $id): string
    {
        return asset(asset('/images/items/' . Product::first($id)->image));
    }

    public function removeOrderObjectFromCart(int $key): void
    {
        $this->cartService->removeOrderObject($key);
        $this->emit('orderObjectsChanged');
    }
}