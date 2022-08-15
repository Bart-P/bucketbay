<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public $success_msg;

    public function index()
    {
        return view('addresses.index');
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store()
    {
        if (auth()->user()->id) {
            $user_id = (string)auth()->user()->id;
            $form_fields = request()->validate([
                'user_id' => $user_id,
                'name1' => ['required', Rule::unique('addresses', 'name1')],
                'name2' => '',
                'name3' => '',
                'street' => 'required',
                'street_nr' => 'required',
                'city' => 'required',
                'city_code' => 'required',
                'country' => 'required',
                'address_info' => '',
            ]);

            $form_fields['user_id'] = $user_id;

            Address::create($form_fields);

            return redirect('/addresses')->with('success_msg', 'Adresse hinzugefügt!');
        }
    }

    public function edit(Address $address)
    {
        return view('/addresses/edit', [
            'address' => $address
        ]);
    }

    public function update(Address $address)
    {
        $address_fields = request()->validate([
            'name1' => 'required',
            'name2' => '',
            'name3' => '',
            'street' => 'required',
            'street_nr' => 'required',
            'city' => 'required',
            'city_code' => 'required',
            'country' => 'required',
            'address_info' => '',
        ]);

        $address->updateTimestamps();

        if ($address->update($address_fields)) {
            if ($address->id == session('shopping-cart.delivery-address-id')) {
                session('shopping-cart.delivery-address-id', $address->id);
            }
            return redirect('/addresses')->with('success_msg', 'Adresse erfolgreich bearbeitet!');
        };

        return redirect('/addresses')->with('failed_msg', 'Adresse konnte nicht bearbeitet werden!');
    }

    public function destroy($address_id)
    {
        if (Address::destroy($address_id)) {
            if (session('shopping-cart.delivery-address-id') == $address_id) {
                session('shopping-cart.delivery-address-id', null);
            }
            return redirect('/addresses')->with('success_msg', 'Adresse wurde gelöscht!');
        };
    }
}
