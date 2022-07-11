<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" />

    <title>Bucket Bay</title>
    @livewireStyles
</head>

<body style="min-height: 100vh">
    <header>

        @if (!request()->is('*login*'))
            <nav
                class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-between p-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center col-lg-3 mb-2 mb-lg-0 text-dark text-decoration-none">
                    BucketBay
                </a>

                <ul class="nav col-12 col-lg-auto mb-2 justify-content-center mb-lg-0">
                    <li><a href="/"
                            class="nav-link px-3 {{ request()->is('/') ? 'link-primary' : 'link-dark' }}">Produkte</a>
                    </li>
                    <li>
                        <a href="/grafics"
                            class="nav-link px-3 {{ request()->is('grafics*') ? 'link-primary' : 'link-dark' }}">Grafik</a>
                    </li>
                    <li>
                        <a href="/addresses"
                            class="nav-link px-3 {{ request()->is('addresses*') ? 'link-primary' : 'link-dark' }}">Adressen</a>
                    </li>
                    <li>
                        <a href="/cart"
                            class="nav-link px-3 {{ request()->is('cart*') ? 'link-primary' : 'link-dark' }}">Warenkorb</a>
                    </li>
                    <li>
                        <a href="/orders"
                            class="nav-link px-3 {{ request()->is('orders*') ? 'link-primary' : 'link-dark' }}">Bestellungen</a>
                    </li>
                </ul>

                <div class="col-lg-3 text-end">
                    <button type="button" class="btn btn-outline-primary me-2">
                        Logout
                    </button>
                </div>
            </nav>
        @endif
    </header>

    <main class="h-100">

        {{ $slot }}

    </main>

    <footer>
        <div class="container text-muted text-center py-5">
            <p>some footer test</p>
            <p>build by B for mephistomedia</p>
        </div>
    </footer>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
