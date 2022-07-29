<x-layout>
    <main>
        <x-banner>
            <x-slot:heading> Irgendeine Grafik Überschrift... </x-slot>
                Hier soll eine kurze beschreibung hin was auf dieser Seite gemacht werden kann. Quasi eine
                kurzbeschreibung wie
                man Grafik hochladen kann und welche dateiformate unterstützt werden.
        </x-banner>

        @livewire('grafics-table')
    </main>
</x-layout>
