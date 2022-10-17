<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class CartContainer extends Component
{
    // TODO products-in-cart-table does not refresh when an orderObject is deleted, reproduce by adding and removing "Halterung Einzeln"
    // TODO all functionality from ProductsInCart should be moved here
    // TODO all functionality from OrderObjectTable should be moved here, and OrderObjectTable should be a simple laravel component

    private CartService $cartService;

    public $address;
    public $productsInCart;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function mount()
    {
        $this->address = Address::find($this->cartService->getAddressId());
        $this->refreshProducts();
    }

    public function render()
    {
        return view('livewire.cart-container');
    }

    public function refreshProducts()
    {
        $this->productsInCart = Product::find($this->cartService->getProducts()->keys(), ['id',
                                                                                          'name',
                                                                                          'printable']);
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
        $this->refreshProducts();
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