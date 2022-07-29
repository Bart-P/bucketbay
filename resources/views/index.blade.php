<x-layout>

    <x-banner>
        <x-slot:heading>Irgendeine Überschrift...</x-slot>
            Hier soll eine kurze beschreibung hin was auf dieser Seite gemacht werden kann. Quasi eine kurzbeschreibung
            wie
            man Produkte bestellt und was zu beachten ist.
    </x-banner>

    <x-notification-msg></x-notification-msg>

    <div class="container">
        <div class="row g-3">
            @foreach ($items as $item)
                <div class="col">
                    <div class="card shadow-sm h-100" style="min-width: 300px">
                        <div class="h-100 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('/images/items/' . $item['image']) }}" class="card-img-top p-4"
                                alt="Bild vom Eimer">
                        </div>

                        <div class="card-title text-center pt-4 fw-bold text-uppercase">
                            {{ $item['name'] }}
                        </div>

                        <div class="card-body ">
                            <p class="card-text">
                                {{ $item['description'] }}
                            </p>

                            <button type="button" class="btn btn-outline-success float-end">
                                <i class="bi-basket3-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </section>
</x-layout>
