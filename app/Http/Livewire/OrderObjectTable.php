<?php

namespace App\Http\Livewire;

use App\Models\Grafic;
use App\Models\Product;
use Livewire\Component;

class OrderObjectTable extends Component
{
    // TODO - below is only for testing, delete later.

    private $orderObjectArray = [1 => ['productId'     => 1,
                                       'isPrintable'   => true,
                                       'graficFrontId' => 11,
                                       'graficBackId'  => null,
                                       'quantity'      => 5],
                                 2 => ['productId'     => 2,
                                       'isPrintable'   => true,
                                       'graficFrontId' => 12,
                                       'graficBackId'  => 11,
                                       'quantity'      => 5],
                                 3 => ['productId'   => 3,
                                       'isPrintable' => false,
                                       'quantity'    => 2]];

    public function render()
    {
        $productsInCart = Product::findMany([1, 2, 3]);
        $graficsInCart = Grafic::findMany([12, 11]);
        $cartData = ['products'     => $productsInCart,
                     'grafics'      => $graficsInCart,
                     'orderObjects' => ['printable'    => array_filter($this->orderObjectArray, function ($obj) {
                         return $obj['isPrintable'] === null ? false : $obj['isPrintable'];
                     }),
                                        'notPrintable' => array_filter($this->orderObjectArray, function ($obj) {
                                            return $obj['isPrintable'] === null ? false : !$obj['isPrintable'];
                                        })]];

        return view('livewire.order-object-table', $cartData);
    }
}