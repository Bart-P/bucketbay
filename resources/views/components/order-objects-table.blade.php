<div x-data>
    <table class="table table-bordered h-100">
        <tr class="text-center">
            <th>Menge</th>
            <th>€/St.</th>
            <th>Bild</th>
            <th>Name</th>
            <th>Grafik1</th>
            <th>Grafik2</th>
            <th>Menge Ändern</th>
            <th>Verfügbar</th>
            <th></th>
        </tr>
        @if($orderObjects)

            @foreach($orderObjects->sortBy('productId') as $key => $orderObject)

                <tr>
                    <td class="p-3 align-middle text-center">
                        <b>
                            {{ $orderObject['quantity'] }}x
                        </b>
                    </td>
                    <td class="p-3 align-middle text-center">
                        {{ $this->getFormatedFinalPrice($products->find($orderObject['productId'])->price_in_cent, count($orderObject['grafics'])) }}
                        {{--
                                            {{ $this->productService->formatCurrency($products->find($orderObject['productId'])->price_in_cent) }}
                        --}}
                    </td>
                    <td class="text-center align-middle">
                        <img src="{{ asset('images/items/' . $products->find($orderObject['productId'])->image) }}"
                             class="img-fluid product-image-sm" alt="">
                    </td>
                    <td>
                        <div class="d-flex h-100 align-middle align-items-center">
                            {{ $products->find($orderObject['productId'])->name }}
                            <span class="ms-2 text-muted fs-6 fst-italic">id: {{ $orderObject['productId'] }}</span>
                        </div>
                    </td>
                    @for($i=0; $i<2; $i++)
                        <td>
                            <div class="d-flex h-100 justify-content-center align-items-center gap-3">
                                @if(isset($orderObject['grafics'][$i]) && $grafics->find($orderObject['grafics'][$i]))
                                    <div class="h-100 w-100" style="position: relative;">
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <img src="{{asset('storage/grafics/' . $grafics->find($orderObject['grafics'][$i])['file'])}}"
                                                 class="img-fluid rounded m-auto"
                                                 style="height: 50px; width: 75px; object-fit: cover;"
                                                 alt="">
                                        </div>
                                        <button wire:click="removeGraficsFromOrderObject({{$key}}, {{$i}})"
                                                class="btn btn-sm btn-outline-secondary border-0 p-1 m-0"
                                                style="position: absolute; top: 0; right: 0;"><i
                                                    class="bi-x-circle"></i>
                                        </button>
                                    </div>
                                @elseif($products->find($orderObject['productId'])->printable)
                                    <button wire:click="selectGraficForOrderObject({{ $key }})"
                                            x-on:click="showModal = true"
                                            class="btn btn-lg btn-outline-primary border-0"><i
                                                class="bi-printer"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    @endfor
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
                    <td class="p-3 align-middle text-center">
                        {{ $products->find($orderObject['productId'])->quantity_available }}
                    </td>
                    <td class="text-center align-middle">
                        <button wire:click="removeOrderObjectFromCart({{ $key }})"
                                class="btn btn-outline-danger border-0">
                            <i class="bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
    {{--
        <div class="modal-overlay w-100 h-100 bg-dark justify-content-center align-items-center"
             x-show="showModal" x-cloak x-transition.opacity>
        </div>
        <div x-show="showModal" @click.away="showModal=false" x-cloak class="card modal-card bg-white" x-transition>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title">Grafik auswählen: </h5>
                    <button @click="showModal=false" class="btn btn-sm btn-outline-secondary border-0"><i
                                class="bi-x-circle"></i>
                    </button>
                </div>
                <table class="table table-hover">
                    @foreach($grafics as $grafic)
                        <tr @click="$wire.selectGrafic({{$grafic['id']}}); showModal = false"
                            class="align-middle p-2 grafic-select-object">
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
    --}}
</div>