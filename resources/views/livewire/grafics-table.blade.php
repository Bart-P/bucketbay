<x-table-wrapper>
    <x-table-controlls-wrapper>
        <button type="button" class="btn btn-outline-primary m-4" data-bs-toggle="modal"
            data-bs-target="#uploadGraficsModal">
            Grafik Hochladen
        </button>
    </x-table-controlls-wrapper>

    <!-- Upload Grafics Modal -->
    <div class="modal fade" id="uploadGraficsModal" tabindex="-1" aria-labelledby="uploadGraficsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Grafik hochladen
                    </h5>
                </div>

                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body d-flex flex-column gap-3">
                        <div class="input-group">
                            <label for="fileName" class="input-group-text">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <input type="file" class="form-control" name="file">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Abbrechen
                        </button>

                        <button type="submit" class="btn btn-outline-primary">
                            Speichern
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Delete Confirmation Grafics Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Grafik Löschen?
                    </h5>
                </div>
                <div class="modal-body">
                    Soll die Grafik mit der ID {{ $selectedImageId }} unwiederruflich gelös
                    cht werden?
                </div>

                <form method="POST" action="/grafics/{{ $selectedImageId }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Abbrechen
                        </button>

                        <button type="submit" class="btn  btn-danger">
                            Löschen
                        </button>
                    </div>
                </form>

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
                <th scope="col">MB</th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($grafics as $grafic)
                <th scope="row">{{ $grafic->id }}</th>
                <td>
                    @if ($grafic->file != 'placeholder_150x100.png' && !empty($grafic->file))
                        <img src="{{ asset('storage/grafics/' . $grafic->file) }}" alt="logo"
                            class="img-fluid rounded" style="height: 100px; width: 150px; object-fit: cover;" />
                    @else
                        <img src="{{ asset('images/' . $grafic->file) }}" alt="logo" class="rounded-2" />
                    @endif
                </td>
                <td x-data="{ open: false }">
                    <form x-show="open" @click.outside="open = false" method="POST"
                        action="/grafics/{{ $grafic->id }}">
                        @csrf
                        @method('PUT')
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save"></i>
                            </button>
                            <input type=" text" name="name" class="form-control form-control-sm"
                                value="{{ $grafic->name }}">
                        </div>
                    </form>
                    <span x-show="!open">
                        <button @click="open = ! open" class="btn btn-outline-secondary btn-sm" style="border: none;">
                            <i class="bi-pen"></i>
                        </button>
                        {{ $grafic->name }}
                    </span>
                </td>
                <td>{{ $grafic->type }}</td>
                <td>{{ $grafic->size_in_mb }}</td>
                <td class="">
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-outline-success">
                            <i class="bi-basket3-fill"></i>
                        </button>

                        <button class="btn btn-outline-success">
                            <i class="bi-download"></i>
                        </button>

                        <button class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal"
                            wire:click="deleteConfirmation({{ $grafic->id }})">
                            <i class="bi-trash"></i>
                        </button>
                    </div>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mx-4">
        {{ $grafics->links() }}
        <div class="mb-3">
            <select wire:model="itemsPerPage" name="perPageCount" class="form-select form-select-sm fs-5">
                <option selected="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
</x-table-wrapper>
