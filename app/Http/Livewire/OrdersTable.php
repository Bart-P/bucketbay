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
        $this->orders = Order::join('addresses', 'addresses.id', '=', 'orders.delivery_address_id')->select('addresses.name1', 'orders.*')->get();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders-table');
    }
}