<x-layout>
    <x-banner>
        <x-slot:heading>Irgendeine Überschrift...</x-slot>
            Hier soll eine kurze beschreibung hin was auf dieser Seite gemacht werden kann. Quasi eine kurzbeschreibung
            wie
            man Produkte bestellt und was zu beachten ist.
    </x-banner>

    <x-notification-msg></x-notification-msg>

    <div class="container">

    @livewire('products-list')

    </div>
</x-layout>
