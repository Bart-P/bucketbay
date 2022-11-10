<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatusEnum;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersTable extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';
    public int $itemsPerPage = 10;

    public $filterField = 'status';
    public $filter = '';

    public $searchField = 'addresses.name1';
    public $search = '';

    public function render(): Factory|View|Application
    {
        $orders = auth()->user()->orders()
                        ->where($this->filterField, 'like', '%' . $this->filter . '%')
                        ->join('addresses', 'addresses.id', '=', 'orders.delivery_address_id')
                        ->select('addresses.name1', 'orders.*')
                        ->where($this->searchField, 'like', '%' . $this->search . '%')
                        ->orwhere('addresses.id', 'like', $this->search);

        return view('livewire.orders-table', ['orders' => $orders->orderBy('status')->orderBy('created_at', 'DESC')->paginate($this->itemsPerPage)]);
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

    public function getStatusInDE(string $statusEnum): string
    {
        $name = match ($statusEnum) {
            OrderStatusEnum::OPEN->value       => 'offen',
            OrderStatusEnum::INPROGRESS->value => 'in bearbeitung',
            OrderStatusEnum::SENT->value       => 'versendet',
            OrderStatusEnum::INVOICED->value   => 'rechnung gestellt',
            OrderStatusEnum::CLOSED->value     => 'bezahlt',
            OrderStatusEnum::CANCELLED->value  => 'abgebrochen',
            default                            => '',
        };;
        return $name;
    }

    public function orderChangePossible(string $statusEnum): bool
    {
        return OrderStatusEnum::OPEN->value === $statusEnum;

    }
}