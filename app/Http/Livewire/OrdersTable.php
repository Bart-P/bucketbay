<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrdersTable extends Component
{
    public $orders;

    public function boot()
    {
        $this->orders = Order::all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders-table');
    }

    public function getAddressName(int $addressId)
    {
        return $addressId;
    }
}