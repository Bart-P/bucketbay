<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Grafic;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class CartController extends Controller
{
    /**
     * @return View|Factory
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function index()
    {
        $currentAddress = Address::find(session('shopping-cart.delivery-address-id'));

        return view('cart.index', [
            'address' => $currentAddress,
        ]);
    }
}
