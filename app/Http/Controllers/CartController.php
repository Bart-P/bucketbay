<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): Factory|View|Application
    {
        $currentAddress = Address::find($this->cartService->getAddressId());
        return view('cart.index', ['address' => $currentAddress]);
    }
}