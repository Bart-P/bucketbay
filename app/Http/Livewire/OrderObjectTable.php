<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class OrderObjectTable extends Component
{

    protected $listeners = [
        'orderObjectsChanged',
        'graficForOrderObjectSelected' => 'selectGrafic',
    ];

    private CartService $cartService;
    private ProductService $productService;

    public Collection $orderObjects;
    public Collection $productsInCart;
    public Collection $productsInCartUpdated;
    public $newQuantities = [];
    public $grafics;
    public int $selectedOrderObjectKey;
    public int $selectedGraficId;
    public int $priceForPrint;
    public int $priceForShipmentInCent;

    public function boot(CartService $cartService, ProductService $productService)
    {
        $this->priceForShipmentInCent = 999;
        $this->productService = $productService;
        $this->cartService = $cartService;
        $this->orderObjectsChanged();
        $this->priceForPrint = $productService->getPriceForPrint();
    }

    public function render(): Factory|View|Application
    {
        $this->productsInCartUpdated = $this->productService->updateProductQuantities($this->productsInCart);
        return view('livewire.order-object-table', ['products' => $this->productsInCartUpdated]);
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

    public function getGraficPath(int $productId): string
    {
        return asset(asset('/images/items/' . Product::first($productId)->image));
    }

    public function removeOrderObjectFromCart(int $orderObjectKey): void
    {
        $this->cartService->removeOrderObject($orderObjectKey);
        $this->emit('orderObjectsChanged');
        $this->emit('removedProductFromCart');
    }

    public function getFormatedFinalPrice(int $productPrice, int $printAmount = 0): float
    {
        return ($printAmount * $this->priceForPrint + $productPrice) / 100;
    }

    public function getQuantitySumOfProductFromOrderObjects(int $productId): int
    {
        $sum = 0;
        if (isset($this->productsInCartUpdated)) {
            foreach ($this->orderObjects as $orderObject) {
                if ($orderObject['product_id'] === $productId) {
                    $sum += $orderObject['quantity'];
                }
            }
        }

        return $sum;
    }

    public function getPriceSumOfProductFromOrderObjects(int $productId): int
    {
        $sum = 0;
        if (isset($this->productsInCartUpdated)) {
            foreach ($this->orderObjects as $orderObject) {
                if ($orderObject['product_id'] === $productId) {
                    $sum += $this->productsInCartUpdated->find($productId)->price_in_cent * $orderObject['quantity'];
                }
            }
        }

        return $sum;
    }

    public function getGraficsQuantitySum(): int
    {
        $sum = 0;

        foreach ($this->orderObjects as $orderObject) {
            if (isset($orderObject['grafics'])) {
                $sum += count($orderObject['grafics']) * $orderObject['quantity'];
            }
        }

        return $sum;
    }

    public function getGraficsPriceSum(): float
    {
        return $this->getGraficsQuantitySum() * $this->priceForPrint;
    }

    public function getPriceSumNet(): int
    {
        $sum = $this->getGraficsPriceSum() + $this->priceForShipmentInCent;

        foreach ($this->orderObjects as $orderObject) {
            $sum += $this->productsInCartUpdated->find($orderObject['product_id'])['price_in_cent'] * $orderObject['quantity'];
        }

        return $sum;
    }

    public function updateQuantity($orderObjectKey)
    {
        if ($this->newQuantities[$orderObjectKey] < 1) {
            $this->removeOrderObjectFromCart($orderObjectKey);
        } else {
            $this->cartService->updateOrderObjectQuantity($orderObjectKey, $this->newQuantities[$orderObjectKey]);
        }
        $this->emit('notifySuccess', 'Auflange geändert!');
        $this->emit('orderObjectsChanged');
    }

    public function selectGraficForOrderObject(int $key)
    {
        $this->selectedOrderObjectKey = $key;
        $this->emit('showSelectGraficsModal', $key);
    }

    public function selectGrafic($id)
    {
        $this->selectedGraficId = $id;
        $this->setGraficForOrderObject($this->selectedOrderObjectKey, $id);
    }

    public function setGraficForOrderObject(int $orderObjectKey, int $graficId)
    {
        $this->cartService->setGraficForOrderObject($orderObjectKey, $graficId);
        $this->emit('orderObjectsChanged');
    }

    public function removeGraficsFromOrderObject(int $orderObjectKey, int $graficsArrayKey)
    {
        $this->cartService->removeGraficFromOrderObject($orderObjectKey, $graficsArrayKey);
        $this->emit('orderObjectsChanged');
    }
}