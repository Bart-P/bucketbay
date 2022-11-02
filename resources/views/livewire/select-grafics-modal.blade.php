<div x-data="{shown: @entangle('show')}">
    <div class="modal-overlay w-100 h-100 bg-dark justify-content-center align-items-center"
         x-show="shown" x-cloak x-transition.opacity>
    </div>
    <div x-show="shown" @click.away="$wire.hideModal()" class="card modal-card bg-white" x-cloak>
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Grafik auswählen: </h5>
                <button @click="$wire.hideModal()" class="btn btn-sm btn-outline-secondary border-0"><i
                            class="bi-x-circle"></i>
                </button>
            </div>
            <table class="table table-hover">
                @if($grafics)
                    @foreach($grafics->sortByDesc('updated_at') as $grafic)
                        <tr @click="$wire.selectGraficsForOrderObject({{ $grafic['id'] }}); showModal = false"
                            class="align-middle p-2 grafic-select-object">
                            <td><img class="grafic-preview-sm" src="{{ asset('storage/grafics/' . $grafic['file']) }}"
                                     alt="">
                            </td>
                            <td>{{ $grafic['name'] }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>