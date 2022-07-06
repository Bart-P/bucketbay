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
    $form_fields = request()->validate([
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

    Address::create($form_fields);

    return redirect('/addresses')->with('success_msg', 'Adresse hinzugefügt!');
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

    $address->update($address_fields);

    return redirect('/addresses')->with('success_msg', 'Adresse erfolgreich bearbeitet!');
  }

  public function destroy($address_id)
  {
    Address::destroy($address_id);
    return redirect('/addresses')->with('success_msg', 'Adresse wurde gelöscht!');
  }
}
