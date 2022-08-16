<div class="d-flex gap-3 flex-column">
    @foreach ($grafics as $grafic)
        <div class="">
            <div x-data="{ open: false }" class="d-flex gap-4 align-items-center justify-content-between">
                <div class="">
                    <!-- TODO this code is used twice, should be put in a separate component? -->
                    @if ($grafic->file != 'placeholder_150x100.png' && !empty($grafic->file))
                        <img src="{{ asset('storage/grafics/' . $grafic->file) }}" alt="logo" class="img-fluid rounded"
                            style="height: 100px; width: 150px; object-fit: cover;" />
                    @else
                        <img src="{{ asset('images/' . $grafic->file) }}" alt="logo" class="rounded-2" />
                    @endif
                </div>
                <div class="d-flex my-auto">
                    <table class="table">
                        <tr>
                            <th>Name: </th>
                            <td>{{ $grafic->name }}</td>
                        </tr>
                        <tr>
                            <th>Typ: </th>
                            <td>{{ $grafic->type }}</td>
                        </tr>
                        <tr>
                            <th>Größe: </th>
                            <td>{{ $grafic->size_in_mb }} MB</td>
                        </tr>
                    </table>
                </div>
                <div @click.outside="open = false"
                    class="d-flex my-auto gap-1 justify-content-center align-items-center">
                    <button x-show="!open" @click="open = ! open" class="btn btn-sm btn-outline-secondary"
                        style="border: none">
                        <i class="bi-pencil"></i>
                    </button>
                    <span class="d-flex justify-content-center align-items-center" style="max-width: 80px;">
                        <input x-show="open" class="form-control text-end" type="number" value=4>
                        <span x-show="!open">4</span>
                    </span>x
                    <select x-show="open" name="" id="" class="form-control">
                        <option value="1">Einseitiger</option>
                        <option value="2">Zweiseitiger</option>
                    </select>
                    <span x-show="!open">Einseitiger</span>
                    <button x-show="open" class="btn btn-success">
                        <i class="bi-save"></i>
                    </button>
                    <span x-show="!open">Druck</span>
                </div>
                <div class="">
                    <button class="btn btn-outline-danger">
                        <i class="bi-trash"></i>
                    </button>
                </div>
            </div>
            <hr>
        </div>
    @endforeach
</div>
