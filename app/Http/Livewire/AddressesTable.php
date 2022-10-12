<?php

namespace App\Http\Livewire;

use App\Models\Address;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AddressesTable extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public int $itemsPerPage = 15;
    public string $search = '';
    public int $selected_address_id = 0;
    public Address $selectedAddress;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedItemsPerPage()
    {
        $this->resetPage();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.addresses-table', ['addresses' => Address::search($this->search)->latest('updated_at')->paginate($this->itemsPerPage),]);
    }

    public function setAddressToBeDeleted(Address $address)
    {
        $this->selected_address_id = $address['id'];
        $this->selectedAddress = $address;
    }

    public function setDeliveryAddressInCart($address_id)
    {
        session(['shopping-cart.delivery-address-id' => $address_id]);
        $this->emit('notifySuccess', 'Lieferadresse gesetzt');
    }
}