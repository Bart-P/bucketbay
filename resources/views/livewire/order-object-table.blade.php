<div x-data>
    <table class="table table-bordered h-100">
        <tr class="text-center">
            <th>Menge</th>
            <th>Bild</th>
            <th>Name</th>
            <th>Grafik1</th>
            <th>Grafik2</th>
            <th>Menge Ändern</th>
            <th></th>
        </tr>
        @foreach($orderObjects as $key => $orderObject)

            <tr>
                <td class="p-3 align-middle text-center">
                    <b>
                        {{ $orderObject['quantity'] }}x
                    </b>
                </td>
                <td class="text-center align-middle">
                    <img src="{{ asset('images/items/' . $products->find($orderObject['productId'])->image) }}"
                         class="img-fluid" style="height: 100px" alt="">
                </td>
                <td>
                    <div class="d-flex h-100 align-middle align-items-center">
                        {{ $products->find($orderObject['productId'])->name }}
                        <span class="ms-2 text-muted fs-6 fst-italic">id: {{ $orderObject['productId'] }}</span>
                    </div>
                </td>
                <td>
                    <div class="d-flex h-100 justify-content-center align-items-center gap-3">
                        @if(count($orderObject['grafics']) < 1 && $products->find($orderObject['productId'])->printable )
                            {{--
                                                <img src="{{asset('storage/grafics/' . $grafics->find($printable['graficFrontId'])->file)}}"
                                                     class="img-fluid rounded" style="height: 50px; width: 75px; object-fit: cover;" alt="">
                            {{ $grafics->find($printable['graficFrontId'])->name }}
                            --}}
                            <button wire:click="selectGraficForOrderObject({{ $key }})"
                                    x-on:click="showModal = true"
                                    class="btn btn-lg btn-outline-primary border-0"><i
                                        class="bi-printer"></i>
                            </button>
                        @else
                            <button class="btn btn-outline-secondary border-0"><i class="bi-x-circle"></i></button>
                        @endif
                    </div>
                </td>
                <td class="d-flex h-100 justify-content-center align-items-center">
                    {{--
                                    @if( $printable['graficBackId'] !== null )
                                        <img src="{{asset('storage/grafics/' . $grafics->find($printable['graficBackId'])->file)}}"
                                             class="img-fluid rounded" style="height: 50px; width: 75px; object-fit: cover;"
                                             alt="">
                                        {{ $grafics->find($printable['graficBackId'])->name }}
                        <button class="btn btn-outline-secondary border-0"><i class="bi-x-circle"></i></button>
                    @else
                    --}}
                    @if(count($orderObject['grafics']) === 1 )
                        <button class="btn btn-lg btn-outline-primary border-0"><i
                                    class="bi-printer"></i>
                        </button>
                    @elseif(count($orderObject['grafics']) > 1)
                        {{--
                                            <img src="{{asset('storage/grafics/' . $grafics->find($printable['graficFrontId'])->file)}}"
                                                 class="img-fluid rounded" style="height: 50px; width: 75px; object-fit: cover;" alt="">
                        {{ $grafics->find($printable['graficFrontId'])->name }}
                        --}}
                        <button class="btn btn-outline-secondary border-0"><i class="bi-x-circle"></i></button>
                    @endif
                    {{--
                                    @endif
                    --}}
                </td>
                <td>
                    <form wire:submit.prevent="updateQuantity({{$key}})"
                          class="d-flex justify-content-center align-items-center gap-2 h-100">
                        @csrf
                        <label>
                            <input name="productQuantity" type="number"
                                   wire:model="newQuantities.{{ $key }}"
                                   class="form-control" min=0
                                   style="max-width: 70px">
                        </label>
                        <button class="btn btn-outline-success border-0" style="max-width: 50px"><i
                                    class="bi-save"></i>
                        </button>

                    </form>
                </td>
                <td class="text-center align-middle">
                    <button wire:click="removeOrderObjectFromCart({{ $key }})"
                            class="btn btn-outline-danger border-0">
                        <i class="bi-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="modal-overlay w-100 h-100 bg-dark justify-content-center align-items-center"
         x-show="showModal" x-cloak>
    </div>
    <div x-show="showModal" @click.away="showModal=false" x-cloak class="card modal-card bg-white">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Grafik auswählen: </h5>
                <button @click="showModal=false" class="btn btn-sm btn-outline-secondary border-0"><i
                            class="bi-x-circle"></i>
                </button>
            </div>
            <table class="table table-hover">
                @foreach($grafics as $grafic)
                    <tr @click="$wire.selectGrafic({{$grafic['id']}}); showModal = false" class="align-middle p-2">
                        <td><img class="grafic-preview-sm" src="{{ asset('storage/grafics/' . $grafic['file']) }}"
                                 alt="">
                        </td>
                        <td>{{ $grafic['name'] }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>