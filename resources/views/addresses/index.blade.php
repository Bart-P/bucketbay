<x-layout>
  <main>
    <x-banner>
      <x-slot:heading>Address header</x-slot:heading>
      irgendwelche addresinfos wenns gebraucht wird..
    </x-banner>

    @livewire('addresses-table')

    <x-success-msg></x-success-msg>

  </main>
</x-layout>
