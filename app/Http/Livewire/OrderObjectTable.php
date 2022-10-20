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

    // TODO There is a bug, when amounts are changed the quantity of "Ice Bucket mit Halterung" jumps to zero..

    protected $listeners = ['orderObjectsChanged', 'graficForOrderObjectSelected' => 'selectGrafic'];

    private CartService $cartService;

    public Collection $orderObjects;
    public Collection $productsInCart;
    public $newQuantities = [];
    public $grafics;
    public int $selectedOrderObjectKey;
    public int $selectedGraficId;
    public int $priceForPrint;

    public function boot(CartService $cartService, ProductService $productService)
    {
        $this->cartService = $cartService;
        $this->orderObjectsChanged();
        $this->priceForPrint = Product::find(1, ['price_in_cent'])->value('price_in_cent');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.order-object-table', ['products' => $this->productsInCart,]);
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

    public function getGraficPath(int $id): string
    {
        return asset(asset('/images/items/' . Product::first($id)->image));
    }

    public function removeOrderObjectFromCart(int $key): void
    {
        $this->cartService->removeOrderObject($key);
        $this->emit('orderObjectsChanged');
        $this->emit('removedProductFromCart');
    }

    public function getFormatedFinalPrice(int $productPrice, int $printAmount = 0): float
    {
        return ($printAmount * $this->priceForPrint + $productPrice) / 100;
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