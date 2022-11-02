<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatusEnum;
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

    public function getPillClass(string $statusEnum): string
    {
        $text = 'text-white';
        if ($statusEnum === OrderStatusEnum::CANCELLED->value || $statusEnum === OrderStatusEnum::CLOSED->value) $text = 'text-dark';
        $class = match ($statusEnum) {
            OrderStatusEnum::OPEN->value       => 'bg-primary',
            OrderStatusEnum::INPROGRESS->value => 'bg-secondary',
            OrderStatusEnum::SENT->value       => 'bg-info',
            OrderStatusEnum::INVOICED->value   => 'bg-success',
            OrderStatusEnum::CLOSED->value     => 'bg-light',
            OrderStatusEnum::CANCELLED->value  => 'bg-warning',
            default                            => '',
        };;

        $class .= ' ' . $text;

        return $class;
    }
}