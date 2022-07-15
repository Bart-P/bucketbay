<nav
    class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-between p-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center col-lg-3 mb-2 mb-lg-0 text-dark text-decoration-none">
        BucketBay
    </a>

    <ul class="nav col-12 col-lg-auto mb-2 justify-content-center mb-lg-0">
        <li><a href="/" class="nav-link px-3 {{ request()->is('/') ? 'link-primary' : 'link-dark' }}">Produkte</a>
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

    <form method="post" action="/logout" class="col-lg-3 text-end">
        <span class="me-2">Nutzer: {{ auth()->user()->name }}</span>
        @csrf
        <button type="button" class="btn rounded-circle btn-primary">
            <i class="bi bi-person-fill"></i>
        </button>
        <button type="submit" class="btn rounded-circle btn-secondary me-2">
            <i class="bi bi-box-arrow-right"></i>
        </button>
    </form>
</nav>
