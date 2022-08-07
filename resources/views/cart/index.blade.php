<x-layout>
    <main>
        <x-banner>
            <x-slot:heading> Warenkorb </x-slot>
                Hier eine kurze beschreibung wie der Warenkorb funktioniert...
        </x-banner>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Produkte im Warenkorb</span>
                        <span class="badge bg-primary rounded-pill">3</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Eimer mit Halterung</h6>
                                <small class="text-muted">Kurzbeschreibung</small>
                            </div>
                            <span class="text-muted"><span>4</span> Stück</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Eimer einzeln</h6>
                                <small class="text-muted">Kurzbeschreibung</small>
                            </div>
                            <span class="text-muted"><span>4</span> Stück</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Halterung einzeln</h6>
                                <small class="text-muted">Kurzbeschreibung</small>
                            </div>
                            <span class="text-muted"><span>4</span> Stück</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Druck</h6>
                                <small class="text-muted">Kurzbeschreibung</small>
                            </div>
                            <span class="text-muted"><span>4</span> Stück</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-6">
                    <h4 class="mb-3 text-primary">Lieferadresse</h4>
                    <table>
                        <tr>
                            <td>mephistomedia GmbH</td>
                        </tr>
                        <tr>
                            <td>Herr Daniel du Bois</td>
                        </tr>
                        <tr>
                            <td>in der Mark 107</td>
                        </tr>
                        <tr>
                            <td>44869 Bochum</td>
                        </tr>
                        <tr>
                            <td>Deutschland</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <!-- TODO finnish up cart view -->
                <div class="col-lg-3">
                    <img src="{{ asset('images/placeholder_150x100.png') }}" alt="" srcset="">

                </div>
                <div class="col-lg-9">

                </div>
            </div>

            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
        </div>
    </main>
</x-layout>
