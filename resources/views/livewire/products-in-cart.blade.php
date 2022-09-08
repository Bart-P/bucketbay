<div class="col-md-6 col-lg-6 order-md-last">
    <h4 class="text-primary">Produkte</h4>
    <ul class="list-group mb-3">
        @foreach($products as $product)
            <li class="list-group-item d-flex justify-content-between lh-sm align-items-center">
                <div>
                    {{ $product->name }}
                </div>
                @if($product->printable)
                    <button wire:click="addProductToOrderObjects({{ $product->id }})"
                            class="btn btn-outline-success border-0 ms-auto">
                        <i class="bi-plus-circle"></i></button>
                @else
                    <button class="btn btn-outline-danger border-0 ms-auto"><i class="bi-trash"></i></button>
                @endif
            </li>
        @endforeach
    </ul>
</div>