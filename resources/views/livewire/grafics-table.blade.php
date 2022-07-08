<x-table-wrapper>
    <x-table-controlls-wrapper>
        <button type="button" class="btn btn-outline-primary m-4" data-bs-toggle="modal"
            data-bs-target="#uploadGraficsModal">
            Grafik Hochladen
        </button>
    </x-table-controlls-wrapper>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="uploadGraficsModal" tabindex="-1" aria-labelledby="uploadGraficsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadGraficsModal">
                        Grafik hochladen
                    </h5>
                </div>

                <div class="modal-body">
                    TODO - modal mit preview ausarbeiten
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Abbrechen
                    </button>

                    <button type="button" class="btn btn-outline-primary">
                        Speichern
                    </button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Logo</th>
                <th scope="col">Name</th>
                <th scope="col">Typ</th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($grafics as $grafic)
                <tr>
                    <th scope="row">{{ $grafic->id }}</th>
                    <td>
                        <img src="{{ asset('images/' . $grafic->file) }}" alt="logo" class="rounded-2" />
                    </td>
                    <td>{{ $grafic->name }}</td>
                    <td>{{ $grafic->type }}</td>
                    <td>
                        <button class="btn btn-outline-success m-1 m-sm-0">
                            <i class="bi-basket3-fill"></i>
                        </button>

                        <button class="btn btn-outline-danger m-1 m-sm-0" data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal"
                            wire:click="deleteConfirmation({{ $grafic->id }})">
                            <i class="bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mx-4">
        {{ $grafics->links() }}
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
