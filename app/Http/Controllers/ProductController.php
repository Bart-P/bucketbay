<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('index', ['items' => Item::all()]);
    }

    // TODO refactor each itemslist to a livewire component otherwise wire:click will not work
    public function addProductToCart($id) {
        if(!session('shopping-cart.product-ids')) {
            session()->put('shopping-cart.products-ids', $id);
        } else {
            $currentCartProductIds = session('shopping-cart.product-ids');
            array_push($currentCartProductIds, $id);
            session()->put('shopping-cart.products-ids', $currentCartProductIds);
        }
    }
}
