<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Grafic;

class CartController extends Controller
{
    public function index()
    {
        $currentAddress = Address::find(session('shopping-cart.delivery-address-id'));
        $currentGrafics = [];
        if (session('shopping-cart.grafics')) {
            foreach (session('shopping-cart.grafics') as $graficsId) {
                array_push($currentGrafics, Grafic::find($graficsId));
            };
        }
        return view('cart.index', [
            'address' => $currentAddress,
            'grafics' => $currentGrafics,
        ]);
    }
}
