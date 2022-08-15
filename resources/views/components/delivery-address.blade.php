<div class="col-md-6 col-lg-6">
    <h4 class="mb-3 text-primary">Lieferadresse</h4>
    @if ($address)
        <table>
            <tr>
                <td>{{ $address->name1 }}</td>
            </tr>
            <tr>
                <td>{{ $address->name2 }}</td>
            </tr>
            <tr>
                <td>{{ $address->name3 }}</td>
            </tr>
            <tr>
                <td>{{ $address->street . ' ' . $address->street_nr }}</td>
            </tr>
            <tr>
                <td>{{ $address->city_code . ' ' . $address->city }}</td>
            </tr>
            <tr>
                <td>{{ $address->country }}</td>
            </tr>
            <tr>
                <td>{{ $address->address_info }}</td>
            </tr>
        </table>
    @else
        <p>Keine Addresse ausgewählt</p>
    @endif
</div>
