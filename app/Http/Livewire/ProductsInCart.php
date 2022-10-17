<?php

namespace App\Http\Livewire;

use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductsInCart extends Component
{
    private CartService $cartService;

    protected $listeners = ['orderObjectsDeleted'];

    public $products;

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products-in-cart', ['products' => $this->products]);
    }

    public function deleteProductFromCart($id): void
    {
        $this->cartService->removeProduct($id);
        $this->emit('removedProductFromCart');
        $this->emit('orderObjectsChanged');
        $this->emit('orderObjectsDeleted');
    }

    public function addProductToOrderObjects($productId)
    {
        $orderObject = $this->cartService->createOrderObject($productId, [], 1);
        $this->cartService->addOrderObject($orderObject);
        $this->emit('orderObjectsChanged');
    }

    /*   public function removeProductAndAssociatedOrderObjects(int $productId)
       {
           $this->cartService->removeProductFromCart($productId);
           $this->emit('notifySuccess', 'Produkt aus dem Warenkorb entfernt.');
           $this->emit('orderObjectsChanged');
       }*/

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