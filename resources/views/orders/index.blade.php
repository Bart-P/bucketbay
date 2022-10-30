<x-layout>
    <x-banner>
        <x-slot:heading> Bestellungen</x-slot:heading>
        Hier eine kurze beschreibung wie die Bestellungen funktioniern..
    </x-banner>
    <div class="container">
        @livewire('orders-table')
    </div>
</x-layout>