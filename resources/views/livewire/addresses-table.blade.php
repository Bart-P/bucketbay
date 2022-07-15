<x-table-wrapper>
    <x-table-controlls-wrapper>
        <a class="btn btn-outline-primary m-4" href="/addresses/create">
            Adresse Hinzufügen
        </a>
    </x-table-controlls-wrapper>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Soll die Adresse mit der ID
                        {{ $selected_address_id }} unwiederruflich gelöscht werden? </h5>
                </div>

                <form class="modal-footer" action="/addresses/{{ $selected_address_id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-danger">Löschen</button>
                </form>
            </div>
        </div>
    </div>

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
                            <button class="btn btn-outline-success">
                                <i class="bi-basket3-fill"></i>
                            </button>

                            <a class="btn btn-outline-primary" href="/addresses/{{ $address->id }}/edit">
                                <i class="bi-pencil"></i>
                            </a>

                            <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteConfirmationModal"
                                wire:click="deleteConfirmation({{ $address->id }})">
                                <i class="bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
