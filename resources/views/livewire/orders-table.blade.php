<div class="">

    @if($orders)
        <div class="d-flex align-items-center justify-content-center mb-3 gap-5">
            <div class="input-group" style="max-width: fit-content">
                <label for="filter" class="input-group-text">Status:</label>
                <select wire:model="filter" name="filter" class="form-select" aria-label="Default select example">
                    <option selected value="">Alle</option>
                    @foreach(\App\Enums\OrderStatusEnum::cases() as $status)
                        <option value={{ $status->value }}>{{ $this->getStatusInDE($status->value)}}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group" style="max-width: 700px">
                <label for="search" class="input-group-text">Suchen:</label>
                <input type="text" wire:model.debounce.500ms="search" aria-label="Search" name="search"
                       class="form-control"
                       value="{{ old('search') }}"/>
            </div>
        </div>
        <table class="table table-hover table-responsive">
            <tr>
                <thead>
                <th>Status</th>
                <th>ID</th>
                <th>Lieferung an</th>
                <th>Bestellt am</th>
                <th>Versendet am</th>
                <th></th>
                </thead>
            </tr>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>
                        <span @class([$this->getPillClass($order['status']), 'rounded-pill py-1 px-2'])>{{ $this->getStatusInDE($order['status']) }}</span>
                    </td>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name1 }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->sent_at ? : 'Ausstehend' }}</td>
                    <td class="text-end">
                        <button class="btn btn-outline-success" style="border: none;"><i
                                    class="bi-clipboard-plus"></i></button>
                        @if($this->orderChangePossible($order['status']))
                            <button class="btn btn-outline-primary" style="border: none;"><i
                                        class="bi-pencil"></i></button>
                            <button class="btn btn-outline-danger" style="border: none;"><i
                                        class="bi-trash"></i></button>
                        @else
                            <button class="btn btn-outline-primary" style="border: none;"><i
                                        class="bi-eye"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mx-4">
            {{ $orders->links() }}
            <div class="mb-3">
                <label>
                    <select wire:model="itemsPerPage" name="perPageCount" class="form-select form-select-sm fs-5">
                        <option selected value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </label>
            </div>
        </div>
    @endif
</div>