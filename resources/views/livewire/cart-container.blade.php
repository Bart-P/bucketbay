<div class="container">
    <div class="row">
        <x-delivery-address :address="$address"></x-delivery-address>
        <x-products-in-cart-table :products="$productsInCart"></x-products-in-cart-table>
        {{--        @livewire('products-in-cart', ['products' => $productsInCart])--}}
    </div>
    <hr class="my-4">
    <div class="">
        <h3 class="text-primary mb-4">Bestellobjekte</h3>
        {{-- TODO how/where to handle the modal?
                It can be moved here or outside of this component in the Cart itself?
                Separate all modals to own files?
                Modals NEED to be livewire components because the data comes from the Backend.. Emit and Catch values?
        -}}
        {{--        <x-order-objects-table :orderObjects="$orderObjects" :products="$productsInCart"></x-order-objects-table>--}}
        @livewire('order-object-table')
    </div>
    <hr class="my-4">
    <div class="d-flex w-100 justify-content-center">
        <button class="btn btn-primary btn-lg" type="submit">Bestellung auslösen</button>
    </div>
</div>