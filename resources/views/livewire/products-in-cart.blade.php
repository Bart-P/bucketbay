<div class="col-md-6 col-lg-6 order-md-last" xmlns:wire="http://www.w3.org/1999/xhtml">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-primary">Produkte im Warenkorb</span>
        <span class="badge bg-primary rounded-pill">{{ collect($productsInCart)->values()->sum() }}</span>
    </h4>
    <ul class="list-group mb-3">
        @foreach($products as $product)
            <li class="list-group-item d-flex justify-content-between lh-sm align-items-center">
                <div>
                    <h6 class="my-0">{{ $product->name }}</h6>
                </div>
                <div x-data="{edit: false}"
                     class="d-flex gap-1 justify-content-center align-items-center">
                    <span x-show="!edit">{{ $productsInCart[$product->id] }}</span>
                    <span>
                        <label @click.outside="edit = false">
                            <input type="number"
                                   wire:model="newProductQuantities.{{ $product->id }}"
                                   class="form-control text-end" x-show="edit"
                                   style="min-width: fit-content" min="0">
                        </label>
                        <span x-show="!edit">
                            Stück
                        </span>
                    </span>
                    <span class="d-flex">

                        <button x-bind:hidden="!edit" x-on:click="edit = false"
                                wire:click="$emit('updateProductQuantityInCart', {{ $product->id }})"
                                class="btn btn-success border-0">
                            <i class="bi-save"></i></button>

                        <button x-bind:hidden="edit" x-on:click="edit = true"
                                wire:click="$emit('updateNewQuantity', {{ $product->id }})"
                                class="btn btn-outline-primary border-0"><i
                                    class="bi-pen"></i></button>
                        <button class="btn btn-outline-danger border-0"
                                wire:click="deleteProductFromCart({{ $product->id }})"><i class="bi-trash"></i></button>
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
</div>