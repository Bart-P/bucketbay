<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Product;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class CartContainer extends Component
{
    private CartService $cartService;
    private ProductService $productService;
    private OrderService $orderService;

    protected $listeners = [
        'removedProductFromCart' => 'refreshProducts',
        'orderObjectsChanged',
    ];

    public Address|null $address;
    public Collection $grafics;
    public Collection $productsInCart;
    public Collection $orderObjects;
    public $newQuantities = [];
    public int $selectedOrderObjectKey;
    public int $selectedGraficId;
    public int $priceForPrint;
    public int $shipmentPrice = 999;

    public function boot(CartService $cartService, ProductService $productService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->priceForPrint = $productService->getPriceForPrint();
        $this->address = Address::find($this->cartService->getAddressId());
    }

    public function mount()
    {
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

    public function addProductToOrderObjects(int $productId, int $priceInCent)
    {
        $orderObject = $this->cartService->createOrderObject($productId, $priceInCent, [], 1);
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
            if ($order['product_id'] === $productId) {
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

    public function confirmOrder()
    {
        dd($this->cartService->getOrderObjects());
        $this->orderService->saveOrder($this->address['id'], $this->priceForPrint, $this->shipmentPrice, $this->cartService->getOrderObjects());
    }
}