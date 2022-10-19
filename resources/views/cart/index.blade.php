<x-layout>
    <x-banner>
        <x-slot:heading> Warenkorb</x-slot:heading>
        Hier eine kurze beschreibung wie der Warenkorb funktioniert...
    </x-banner>

    @livewire('cart-container', ['grafics' => $grafics])
    @livewire('select-grafics-modal', ['grafics' => $grafics])
</x-layout>