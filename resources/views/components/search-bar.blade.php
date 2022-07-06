<div class="input-group d-flex align-items-center justify-content-center p-3" style="max-width: 700px;">
  <label for="search" class="input-group-text">Suchen:</label>
  <input type="text" wire:model.debounce.500ms="search" aria-label="Search" name="search" class="form-control"
    value="{{ old('search') }}" />
</div>
