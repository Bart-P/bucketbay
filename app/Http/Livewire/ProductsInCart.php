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
    protected $listeners = ['orderObjectsChanged' => 'render'];

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
    }

    public function render(): Factory|View|Application
    {
        $productsInCart = $this->cartService->getProducts();
        return view('livewire.products-in-cart', ['products' => Product::find($productsInCart->keys(), ['id',
                                                                                                        'name',
                                                                                                        'printable'])]);
    }

    public function deleteProductFromCart($id): void
    {
        $this->cartService->removeProduct($id);
        $this->emit('orderObjectsChanged');
    }

    public function addProductToOrderObjects($productId)
    {
        $orderObject = $this->cartService->createOrderObject($productId, [], 1);
        $this->cartService->addOrderObject($orderObject);
        $this->emit('orderObjectsChanged');
    }

    public function removeProductAndAssociatedOrderObjects(int $productId)
    {
        $this->cartService->removeProductFromCart($productId);
        $this->emit('notifySuccess', 'Produkt aus dem Warenkorb entfernt.');
        $this->emit('orderObjectsChanged');
    }

    public function productIsInOrderObjects(int $productId): bool
    {
        foreach ($this->cartService->getOrderObjects() as $order) {
            if ($order['productId'] === $productId) {
                return true;
            }
        }
        return false;
    }
}