<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class CartContainer extends Component
{
    // TODO all functionality from OrderObjectTable should be moved here, and OrderObjectTable should be a simple laravel component

    private CartService $cartService;
    private ProductService $productService;

    protected $listeners = ['removedProductFromCart' => 'refreshProducts',
                            'orderObjectsChanged'];

    public Address|null $address;
    public Collection $grafics;
    public Collection $productsInCart;
    public Collection $orderObjects;
    public $newQuantities = [];
    public int $selectedOrderObjectKey;
    public int $selectedGraficId;
    public int $priceForPrint;

    public function boot(CartService $cartService, ProductService $productService)
    {
        $this->cartService = $cartService;
        $this->productService = $productService;
    }

    public function mount()
    {
        $this->address = Address::find($this->cartService->getAddressId());
        $this->refreshProducts();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.cart-container');
    }

    public function refreshProducts()
    {
        $this->productsInCart = $this->productService->updateProductQuantities(Product::find($this->cartService->getProducts()->keys()));
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

    public function orderObjectsChanged()
    {
        $this->refreshOrderObjects();
        $this->refreshNewQuantities();
    }

    public function refreshOrderObjects()
    {
        $this->orderObjects = $this->cartService->getOrderObjects();
    }

    private function refreshNewQuantities()
    {
        foreach ($this->orderObjects as $orderKey => $orderObject) {
            $this->newQuantities[$orderKey] = $orderObject['quantity'];
        }
    }
}