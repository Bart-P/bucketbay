@inject('cartService', 'App\Services\CartService')
<div class="row g-3">
    @foreach ($items as $item)
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

                    <p class="card-text">
                        {{ $item['description'] }}
                    </p>

                    <div class="{{ $cartService->getQuantity($item->id) > 0 ? 'd-flex justify-content-between' : ''}}">

                        @if($cartService->getQuantity($item->id))
                            <button wire:click="removeOneProductFromCart({{$item->id}})" type="button" class="btn btn-danger">
                                <i class="bi-dash-circle-fill"></i>
                            </button>

                            <span class="my-auto">
                                <b> {{$cartService->getQuantity($item->id)}} Stück im Warenkorb</b>
                            </span>
                        @endif

                        <button wire:click="addOneProductToCart({{$item->id}})" type="button" class="btn {{ $cartService->getQuantity($item->id) > 0 ? 'btn-success' : 'btn-outline-success float-end'}}">
                            <i class="bi-basket3-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
