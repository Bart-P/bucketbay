<x-layout>
  <div class="container">
    <h1 class="text-center my-5">
      Adresse Hinzufügen
    </h1>
    <form action="/addresses" method="post" class="mx-auto" style="max-width: 700px;">
      @csrf
      <div class="row gap-4">
        <div class="col-12">
          <div class="input-group">
            <span class="input-group-text">Name 1*</span><input type="text" name="name1" class="form-control"
              value="{{ old('name1') }}" />
          </div>
          @error('name1')
            <p class="fs-6 mt-1" style="color: red;">{{ $message }}</p>
          @enderror
        </div>
        <div class="col-12">
          <div class="input-group">
            <span class="input-group-text">Name 2</span><input type="text" name="name2" class="form-control"
              value="{{ old('name2') }}" />
          </div>
        </div>
        <div class="  col-12">
          <div class="input-group">
            <span class="input-group-text">Name 3</span><input type="text" name="name3" class="form-control"
              value="{{ old('name3') }}" />
          </div>
        </div>
        <div class="  col-12">
          <div class="row">
            <div class="col-md-8">
              <div class="input-group">
                <span class="input-group-text">Straße*</span><input type="text" name="street" class="form-control"
                  value="{{ old('street') }}" />
              </div>
              @error('street')
                <p class="  fs-6 mt-1" style="color: red;">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">Nr.*</span><input type="text" name="street_nr" class="form-control"
                  value="{{ old('street_nr') }}" />
              </div>
              @error('street_nr')
                <p class="fs-6 mt-1" style="color: red;">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text">PLZ*</span><input type="text" name="city_code" class="form-control"
                  value="{{ old('city_code') }}" />
              </div>
              @error('city_code')
                <p class="  fs-6 mt-1" style="color: red;">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-8">
              <div class="input-group">
                <span class="input-group-text">Stadt*</span><input type="text" name="city" class="form-control"
                  value="{{ old('city') }}" />
              </div>
              @error('city')
                <p class="  fs-6 mt-1" style="color: red;">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="input-group">
            <span class="input-group-text">Land*</span><input type="text" class="form-control" name="country"
              value="{{ old('country') }}" />
          </div>
          @error('country')
            <p class="  fs-6 mt-1" style="color: red;">{{ $message }}</p>
          @enderror
        </div>
        <div class="col-12">
          <div class="input-group">
            <span class="input-group-text">Address Info</span><input type="text" class="form-control"
              name="address_info" value="{{ old('address_info') }}" />
          </div>
          @error('address_info')
            <p class="  fs-6 mt-1" style="color: red;">{{ $message }}</p>
          @enderror
        </div>
      </div>
      <div class="w-100 d-flex justify-content-center align-items-center gap-3 mt-4">
        <a type="button" class="btn btn-secondary" href="/addresses">
          Abbrechen
        </a>
        <button type="submit" class="btn btn-outline-primary">
          Speichern
        </button>
      </div>
    </form>
  </div>
</x-layout>
