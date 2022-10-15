<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
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
    protected $listeners = ['orderObjectsChanged'];

    private CartService $cartService;
    private ProductService $productService;

    public Collection $orderObjects;
    public $newQuantities = [];
    public $grafics;
    public $selectedOrderObjectKey;
    public $selectedGraficId;

    public function boot(CartService $cartService, ProductService $productService)
    {
        $this->cartService = $cartService;
        $this->productService = $productService;
        $this->orderObjectsChanged();
        $this->grafics = Grafic::latest('updated_at')->get();
    }

    public function render(): Factory|View|Application
    {
        $productsInCart = $this->productService->updateProductQuantities(Product::findMany($this->cartService->getProducts()->keys()));
        return view('livewire.order-object-table', ['products' => $productsInCart,]);
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
    }

    public function getFormatedFinalPrice(int $productPrice, int $printAmount = 0): float
    {
        // TODO the 499 should come from DB and not be hardcoded.. It is the price for 1 print.
        return ($printAmount * 499 + $productPrice) / 100;
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