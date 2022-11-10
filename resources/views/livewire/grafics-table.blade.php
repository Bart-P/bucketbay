<x-table-wrapper xmlns:wire="http://www.w3.org/1999/xhtml">
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
                            <label for="name" class="input-group-text">Name</label>
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
            <tr>
                <th scope="row">{{ $grafic->id }}</th>
                <td>
                    <a href="{{ asset('storage/grafics/' . $grafic->file) }}" target="_blank">
                        <!-- TODO this code is used twice, should be put in a separate component? -->
                        @if ($grafic->file != 'placeholder_150x100.png' && !empty($grafic->file))
                            <img src="{{ asset('storage/grafics/' . $grafic->file) }}" alt="logo"
                                 class="img-fluid rounded" style="height: 100px; width: 150px; object-fit: cover;"/>
                        @else
                            <img src="{{ asset('images/' . $grafic->file) }}" alt="logo" class="rounded-2"/>
                        @endif
                    </a>
                </td>
                <td x-data="{ open: false }">
                    <form x-show="open" @click.outside="open = false" x-cloak method="POST"
                          action="/grafics/{{ $grafic->id }}">
                        @csrf
                        @method('PUT')
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-success"><i class="bi-save"></i>
                            </button>
                            <input type="text" name="name" class="form-control form-control-sm"
                                   value="{{ $grafic->name }}">
                        </div>
                    </form>
                    <span x-show="!open">
                        <button @click="open = ! open" class="btn btn-outline-primary btn-sm" style="border: none;">
                            <i class="bi-pen"></i>
                        </button>
                        {{ $grafic->name }}
                    </span>
                </td>
                <td>{{ $grafic->type }}</td>
                <td>{{ $grafic->size_in_mb }}</td>
                <td class="">
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-outline-primary" style="border: none;"
                                wire:click="downloadFile('{{ $grafic->file }}')"><i class="bi-download"></i>
                        </button>

                        <button class="btn btn-outline-danger" style="border: none;"
                                wire:click="setGraficToBeDeleted({{ $grafic }})"
                                @click="showModal=true">
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

        <div x-show="showModal" @click.away="showModal=false" x-cloak class="card confirmation-modal-card bg-white"
             x-transition>
            <div class="card-body p-4">
                @if($graficToBeDeleted)
                    <div class="d-flex flex-column gap-3 justify-content-start">
                        <h3 class="card-title text-danger">Diese Grafikdatei wird unwiederruflich gelöscht: </h3>
                        <table class="table">
                            <tr class="align-middle justify-content-center">
                                <td><img src="{{ asset('storage/grafics/' . $graficToBeDeleted['file']) }}" alt=""
                                         class="product-image-sm"></td>
                                <td>
                                    id: {{ $graficToBeDeleted['id'] }}
                                </td>
                                <td>
                                    name: {{ $graficToBeDeleted['name'] }}
                                </td>
                                <td>
                                    typ: {{ $graficToBeDeleted['type'] }}
                                </td>
                            </tr>
                        </table>

                    </div>
                    <form class="d-flex justify-content-end gap-3" method="POST"
                          action="/grafics/{{ $graficToBeDeleted['id'] }}">
                        @csrf
                        @method('DELETE')

                        <a @click="showModal = false" class="btn btn-secondary border-0">
                            Abbrechen
                        </a>
                        <button type="submit" class="btn btn-danger">
                            Löschen
                        </button>
                    </form>
                @else
                    <h5 class="card-title btn-danger">Etwas ist Schief gelaufen!</h5>
                    <a @click="showModal = false" class="btn btn-secondary border-0 ms-auto mt-3">
                        Schließen
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mx-4">
        {{ $grafics->links() }}
        <div class="mb-3">
            <select wire:model="itemsPerPage" name="perPageCount" class="form-select form-select-sm fs-5">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
</x-table-wrapper>