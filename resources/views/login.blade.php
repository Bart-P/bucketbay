<x-layout>
    <div class="container d-flex align-items-center justify-content-center mt-5" style="height: 75vh; max-width: 500px;">

        <form class="form-control bg-light p-4">
            <h1 class="text-center py-2 mb-4">Bitte Einloggen</h1>
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="staticEmail">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Passwort</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword">
                </div>
            </div>
            <div class="d-flex">
                <button class="btn btn-primary mt-2 ms-auto">Login</button>
            </div>
        </form>
    </div>
</x-layout>
