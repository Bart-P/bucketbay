<ul class="list-group">
    @foreach($orderObjects['printable'] as $printable)
        <li class="list-group-item text-center">
            <h5>{{ $products->find( $printable['productId'])->name }}
                <span class="fst-italic text-muted">
                    ID:
                    {{ $printable['productId'] }}
                </span>
            </h5>
        </li>
        <li class="list-group-item text-center">
            <h6>Grafik Front <span class="fst-italic text-muted">{{ $printable['graficFrontId'] }}</span></h6>
        </li>
        <li class="list-group-item d-flex gap-5 justify-content-center align-items-center">
            <img src="{{ asset('storage/grafics/' . $grafics->find( $printable['graficFrontId'] )->file) }}"
                 class="img-fluid rounded" style="height: 100px; width: 150px; object-fit: cover;" alt="">
            <ul class="list-group">
                <li class="list-group-item">Name: {{ $grafics->find( $printable['graficFrontId'])->name }}</li>
                <li class="list-group-item">Typ: {{ $grafics->find( $printable['graficFrontId'])->type }}</li>
            </ul>
        </li>
        @if($printable['graficBackId'] != null)
            <li class="list-group-item text-center">
                <h6>Grafik Rücken <span class="fst-italic text-muted">{{ $printable['graficBackId'] }}</span></h6>
            </li>
            <li class="list-group-item d-flex gap-5 justify-content-center align-items-center">
                <img src="{{ asset('storage/grafics/' . $grafics->find( $printable['graficBackId'] )->file) }}"
                     class="img-fluid rounded" style="height: 100px; width: 150px; object-fit: cover;" alt="">

                <ul class="list-group">
                    <li class="list-group-item">Name: {{ $grafics->find( $printable['graficBackId'])->name }}</li>
                    <li class="list-group-item">Typ: {{ $grafics->find( $printable['graficBackId'])->type }}</li>
                </ul>
            </li>
        @endif
        <hr>
    @endforeach

    <ul>
        @foreach($orderObjects['notPrintable'] as $notPrintable)
            {{ $notPrintable['productId'] }}
            {{ $products->find( $notPrintable['productId'])->name }}
        @endforeach
    </ul>