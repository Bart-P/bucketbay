<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class ProductsList extends Component
{
    public function render()
    {
        return view('livewire.products-list', ['items' => Item::all()]);
    }

    public function addProductToCart($id) {
        if(session('shopping-cart.products')) {
            $currentCartProductIds = collect(session('shopping-cart.products'));
            if($this->productIdIsInCart($id)) {
                $currentCartProductIds[$id] += 1;
            } else {
                $currentCartProductIds->put($id, 1);
            }
            session()->put('shopping-cart.products', $currentCartProductIds);
        } else {
            session()->put('shopping-cart.products', collect([$id => 1]));
        }

    }

    public function productIdIsInCart($id): bool {
        return collect(session('shopping-cart.products'))->has($id);
    }
}
