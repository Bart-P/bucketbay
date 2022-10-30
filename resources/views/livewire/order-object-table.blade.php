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
        @foreach($orderObjects->sortBy('productId') as $key => $orderObject)

            <tr>
                <td class="p-3 align-middle text-center">
                    <b>
                        {{ $orderObject['quantity'] }}x
                    </b>
                </td>
                <td class="p-3 align-middle text-center">
                    {{ $this->getFormatedFinalPrice($products->find($orderObject['productId'])->price_in_cent, count($orderObject['grafics'])) }}
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
        <tr>
    </table>
    <div class="d-flex flex-column justify-content-center align-items-center pt-5 pe-5">
        <div class="">
            <h4 class="text-primary mb-3">Zusammenfassung</h4>
            <table class="table table-bordered">
                <thead>
                <tr class="">
                    <th>Produkt</th>
                    <th>Menge</th>
                    <th>Stückpreis</th>
                    <th>Gesamt</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    @if( $this->getQuantitySumOfProductFromOrderObjects($product['id']) > 0)
                        <tr class="">
                            <td class="">{{ $product->name }}</td>
                            <td class="text-end">{{ $this->getQuantitySumOfProductFromOrderObjects($product['id']) }}</td>
                            <td class="text-end">{{ $product->price_in_cent / 100 }}€</td>
                            <td class="text-end">
                                {{ $this->getPriceSumOfProductFromOrderObjects($product['id']) / 100 }}€
                            </td>
                        </tr>
                    @endif
                @endforeach
                @if( $this->getGraficsQuantitySum() > 0)
                    <tr class="">
                        <td class=""> Druckkosten</td>
                        <td class="text-end">{{ $this->getGraficsQuantitySum() }}</td>
                        <td class="text-end">{{ $this->priceForPrint / 100 }}€</td>
                        <td class="text-end">{{ $this->getFormatedFinalPrice($this->getGraficsPriceSum()) }}€</td>
                    </tr>
                @endif
                <tr class="">
                    <td class="">Versandpauschale</td>
                    <td class="text-end">1</td>
                    <td></td>
                    <td class="text-end">{{ $priceForShipmentInCent / 100}}€</td>
                </tr>
                <tr class="border-top">
                    <td class="fw-bold">Gesamt Netto</td>
                    <td></td>
                    <td></td>
                    <td class="fw-bold text-decoration-underline text-end">{{ $this->getPriceSumNet() / 100 }}€</td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>