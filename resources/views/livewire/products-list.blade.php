<div class="row g-3">
    @foreach ($items as $item)
        @if($item['show'])
            <div class="col">
                <div class="card shadow-sm h-100" style="min-width: 300px">
                    <div class="h-100 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('/images/items/' . $item['image']) }}" class="card-img-top p-4"
                             alt="Bild vom Eimer">
                    </div>

                    <div class="card-title text-center pt-4 fw-bold text-uppercase">
                        {{ $item['name'] }}
                    </div>

                    <div class="card-body ">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="card-text">
                                {{ $item['quantity_available'] }} Stück Verfügbar
                            </span>
                            <span class="card-text">
                                ab {{ $this->formatCurrency($item['price_in_cent']) }}€
                            </span>

                        </div>

                        <div class="{{ $this->productIdIsSetInCart($item->id) ? 'd-flex justify-content-between' : ''}}">

                            @if($this->productIdIsSetInCart($item->id))
                                <button wire:click="removeProductFromCart({{$item->id}})" type="button"
                                        class="btn btn-danger">
                                    <i class="bi-dash-circle-fill"></i>
                                </button>

                                <span class="my-auto">
                                <b>{{ $this->getProductQuantityFromCart($item->id) ? $this->getProductQuantityFromCart($item->id) : "" }} im Warenkorb</b>

                            </span>
                            @endif

                            <button wire:click="addOneProductToCart({{$item->id}})" type="button"
                                    class="btn {{ $this->productIdIsSetInCart($item->id) ? 'btn-success' : 'btn-outline-success float-end'}}">
                                <i class="bi-basket3-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>