<x-layout>
    <div class="container d-flex align-items-center justify-content-center mt-5" style="height: 75vh; max-width: 500px;">

        <form method="post" action="/users/authenticate" class="form-control bg-light p-4">
            @csrf
            <h1 class="text-center py-2 mb-4">Bitte Einloggen</h1>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="email">
                </div>

                @error('email')
                    <p class="text-center text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Passwort</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password">
                </div>

                @error('password')
                    <p class="text-center text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary mt-2 ms-auto">Login</button>
            </div>
        </form>
    </div>
</x-layout>
