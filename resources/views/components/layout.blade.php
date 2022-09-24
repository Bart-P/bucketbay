<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="<?php echo asset('style.css')?>" type="text/css">

    <title>Bucket Bay</title>
    @livewireStyles
</head>

<body style="min-height: 100vh">
<header>

    @if (!request()->is('*login*'))
        <x-top-navbar></x-top-navbar>
    @endif
</header>

<main class="h-100">
    {{ $slot }}
    <x-notification-msg></x-notification-msg>
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