<?php

namespace App\Http\Controllers;

use App\Models\Address;

class CartController extends Controller
{
    public function index()
    {
        $currentAddress = Address::find(session('shopping-cart.delivery-address-id'));
        return view('cart.index', ['address' => $currentAddress]);
    }
}
