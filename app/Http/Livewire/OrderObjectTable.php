<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderObjectTable extends Component
{
    private CartService $cartService;
    private $orderObjectArray = [1 => ['productId'     => 1,
                                       'isPrintable'   => true,
                                       'graficFrontId' => 11,
                                       'graficBackId'  => 12,
                                       'quantity'      => 5],
                                 2 => ['productId'     => 2,
                                       'isPrintable'   => true,
                                       'graficFrontId' => 12,
                                       'graficBackId'  => 13,
                                       'quantity'      => 5],
                                 3 => ['productId'     => 2,
                                       'isPrintable'   => true,
                                       'graficFrontId' => 12,
                                       'graficBackId'  => null,
                                       'quantity'      => 5],
                                 4 => ['productId'   => 3,
                                       'isPrintable' => false,
                                       'quantity'    => 2],
                                 5 => ['productId'     => 1,
                                       'isPrintable'   => true,
                                       'graficFrontId' => null,
                                       'graficBackId'  => null,
                                       'quantity'      => 5],];

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function render(): Factory|View|Application
    {
        $productsInCart = Product::findMany($this->cartService->getProducts()->keys());
        $graficsInCart = Grafic::findMany([11, 12, 13]);
        $productsWithQuantitiesInCart = [];
        foreach ($productsInCart as $product) {
            $productsWithQuantitiesInCart[] = ['product'  => $product,
                                               'quantity' => $this->cartService->getQuantity($product->id)];
        }
        $cartData = ['products'     => $productsInCart,
                     'grafics'      => $graficsInCart,
                     'inCart'       => $productsWithQuantitiesInCart,
                     'orderObjects' => ['printable'    => array_filter($this->orderObjectArray, function ($obj) {
                         if ($obj['isPrintable'] && $obj['graficFrontId'] !== null) return true;
                         return false;
                     }),
                                        'notPrintable' => array_filter($this->orderObjectArray, function ($obj) {
                                            if ($obj['isPrintable'] && $obj['graficFrontId'] !== null) {
                                                return false;
                                            }
                                            return true;
                                        })]];
        return view('livewire.order-object-table', $cartData);
    }
}