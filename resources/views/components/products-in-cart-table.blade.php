<div class="col-md-6 col-lg-6 order-md-last">
    <h4 class="text-primary">Produkte</h4>
    <ul class="list-group mb-3">
        @foreach($products as $product)
            <li class="list-group-item d-flex justify-content-between lh-sm align-items-center">
                <div>
                    {{ $product->name }}
                </div>
                <div class="">
                    <button class="btn btn-outline-danger border-0 ms-auto"
                            wire:click="removeProductAndAssociatedOrderObjects({{ $product['id'] }})"><i
                                class="bi-trash"></i>
                    </button>
                    @if($product->printable || !$this->productIsInOrderObjects($product->id))
                        <button wire:click="addProductToOrderObjects({{ $product->id }}, {{ $product->price_in_cent }})"
                                class="btn btn-outline-success border-0 ms-auto">
                            <i class="bi-plus-circle"></i></button>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>