<x-layout>
    <main>
        <x-banner>
            <x-slot:heading> Warenkorb </x-slot>
                Hier eine kurze beschreibung wie der Warenkorb funktioniert...
        </x-banner>
        <div class="container">
            <div class="row">
                <x-delivery-address :address="$address"></x-delivery-address>
                @livewire('products-in-cart')
            </div>
            <hr class="my-4">
            <div class="">
                <h4 class="text-primary mb-4">Druck</h4>
                @livewire('grafics-in-cart')
            </div>
            <hr class="my-4">
            <div class="">
                <h4 class="text-primary mb-4">Druck</h4>
                @livewire('order-object-table')
            </div>
            <hr class="my-4">
            <div class="d-flex w-100 justify-content-center">
                <button class="btn btn-primary btn-lg" type="submit">Bestellung auslösen</button>
            </div>
        </div>

    </main>
</x-layout>