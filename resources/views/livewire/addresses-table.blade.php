<x-table-wrapper x-data>
    <x-table-controlls-wrapper>
        <a class="btn btn-outline-primary m-4" href="/addresses/create">
            Adresse Hinzufügen
        </a>
    </x-table-controlls-wrapper>

    <table class="table table-hover table-responsive">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name1</th>
            <th scope="col">Name2</th>
            <th scope="col">Name3</th>
            <th scope="col">Straße</th>
            <th scope="col">H.Nr.</th>
            <th scope="col">Stadt</th>
            <th scope="col">PLZ</th>
            <th scope="col">Land</th>
            <th scope="col"></th>
        </tr>
        </thead>

        <tbody>
        @foreach ($addresses as $address)
            <tr>
                <th scope="row">{{ $address->id }}</th>
                <td>{{ $address->name1 }}</td>
                <td>{{ $address->name2 }}</td>
                <td>{{ $address->name3 }}</td>
                <td>{{ $address->street }}</td>
                <td>{{ $address->street_nr }}</td>
                <td>{{ $address->city }}</td>
                <td>{{ $address->city_code }}</td>
                <td>{{ $address->country }}</td>
                <td style="">
                    <div class="d-flex justify-content-end gap-2">
                        <a wire:click="setDeliveryAddressInCart({{ $address->id }})"
                           class="btn {{ session('shopping-cart.delivery-address-id') == $address->id ? 'btn-success' : 'btn-outline-success' }}"
                           style="border: none;">
                            <i class="bi-basket3-fill"></i>
                        </a>

                        <a class="btn btn-outline-primary" style="border: none;"
                           href="/addresses/{{ $address->id }}/edit">
                            <i class="bi-pencil"></i>
                        </a>

                        <button class="btn btn-outline-danger" style="border: none;"
                                wire:click="setAddressToBeDeleted({{ $address }})"
                                @click="showModal = true">
                            <i class="bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Delete Confirmation Modal -->
    <div x-data>
        <div class="modal-overlay w-100 h-100 bg-dark justify-content-center align-items-center"
             x-show="showModal" x-cloak x-transition.opacity>
        </div>

        <div x-show="showModal" @click.away="showModal=false" x-cloak class="card confirmation-modal-card bg-white">
            <div class="card-body p-4">
                @if($selectedAddress)
                    <div class="d-flex flex-column gap-3 justify-content-start">
                        <h3 class="card-title text-danger">Diese Adresse wird unwiederruflich gelöscht: </h3>
                        <x-delivery-address :address="$selectedAddress"></x-delivery-address>
                    </div>
                    <form class="d-flex justify-content-end gap-3" method="POST"
                          action="/addresses/{{ $selectedAddress['id'] }}">
                        @csrf
                        @method('DELETE')

                        <a @click="showModal = false" class="btn btn-secondary border-0">
                            Abbrechen
                        </a>
                        <button type="submit" class="btn btn-danger">
                            Löschen
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mx-4">
        {{ $addresses->links() }}
        <div class="mb-3">
            <select wire:model="itemsPerPage" name="perPageCount" class="form-select form-select-sm fs-5">
                <option selected="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
</x-table-wrapper>