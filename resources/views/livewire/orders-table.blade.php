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
    @if($orders)
        @foreach($orders as $order)
            <tr>
                <td>
                    <span @class([$this->getPillClass($order->status) . ' rounded-pill py-1 px-2']) class="">{{ $order->status }}</span>
                </td>
                <td>{{ $order->id }}</td>
                <td>{{ $order->name1 }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{{ $order->sent_at ? : 'Ausstehend' }}</td>
                <td class="text-end">
                    <button class="btn btn-outline-primary" style="border: none;"><i
                                class="bi-pencil"></i></button>
                    <button class="btn btn-outline-danger" style="border: none;"><i
                                class="bi-trash"></i></button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>