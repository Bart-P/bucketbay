{{--TODO this has to be deleted? Got replaced by orderobject view. --}}

<div class="d-flex gap-3 flex-column" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="">
        <div class="">
            <table class="w-100 table">
                @foreach ($grafics as $grafic)
                    <tr x-data="{ open: false }" class="table">
                        <td>
                            @if ($grafic->file != 'placeholder_150x100.png' && !empty($grafic->file))
                                <img src="{{ asset('storage/grafics/' . $grafic->file) }}" alt="logo"
                                     class="img-fluid rounded" style="height: 100px; width: 150px; object-fit: cover;"/>
                            @else
                                <img src="{{ asset('images/' . $grafic->file) }}" alt="logo"
                                     class="img-fluid rounded rounded-2"
                                     style="height: 100px; width: 150px; object-fit: cover;"/>
                            @endif
                        </td>
                        <td>
                            <table class="table table-borderless">
                                <tbody class="border-0">
                                <tr>
                                    <th class="col-3">Name:</th>
                                    <td class="col-9">{{ $grafic->name }}</td>
                                </tr>
                                <tr>
                                    <th class="col-3">Typ:</th>
                                    <td class="col-9">{{ $grafic->type }}</td>
                                </tr>
                                <tr>
                                    <th class="col-3">Größe:</th>
                                    <td class="col-9">{{ $grafic->size_in_mb }} MB</td>
                                </tr>

                                </tbody>
                            </table>
                        </td>
                        <td class="align-middle">
                            <div @click.outside="open = false" class="m-auto" style="max-width: 200px;">
                                <table class="table table-borderless align-middle">
                                    <tr>
                                        <th>Menge</th>
                                        <td>
                                            <input class="form-control" type="number" value=4 min=0>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Druck</th>
                                        <td>
                                            <select name="" id="" class="form-control form-select">
                                                <option value="1" selected>Einseitig</option>
                                                <option value="2">Zweiseitig</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>

                        <td class="align-middle text-end">
                            <button wire:click="$emit('removeGraficFromCart', {{ $grafic->id }})"
                                    class="btn btn-outline-danger border-0">
                                <i class="bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>