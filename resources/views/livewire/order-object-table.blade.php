{{--@inject(getGraficPath)--}}

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
                {{ $orderObject['quantity'] }}x
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
                    @if(count($orderObject['grafics']) < 1 )
                        {{--
                                            <img src="{{asset('storage/grafics/' . $grafics->find($printable['graficFrontId'])->file)}}"
                                                 class="img-fluid rounded" style="height: 50px; width: 75px; object-fit: cover;" alt="">
                        {{ $grafics->find($printable['graficFrontId'])->name }}
                        --}}
                        <button class="btn btn-lg btn-outline-primary border-0"><i
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
                <div class="d-flex justify-content-center align-items-center gap-2 h-100">
                    <label>
                        <input name="productQuantity" type="number"
                               value={{ $orderObject['quantity'] }} class="form-control" min=0
                               style="max-width: 70px">
                    </label>
                    <button class="btn btn-outline-success border-0" style="max-width: 50px"><i
                                class="bi-save"></i>
                    </button>

                </div>
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