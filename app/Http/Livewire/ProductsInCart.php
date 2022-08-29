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
    protected $listeners = ['updateProductQuantityInCart', 'updateNewQuantity'];
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

    public function deleteProductFromCart($id): void
    {
        $this->cartService->removeProduct($id);
    }

    public function updateNewQuantity($id)
    {
        $this->newProductQuantities[$id] = $this->cartService->getQuantity($id);
    }

    public function updateProductQuantityInCart($id): void
    {
        $quantity = (int) $this->newProductQuantities[$id];
        $this->cartService->updateQuantity($id, $quantity);
        $this->newProductQuantities = [];
    }
}