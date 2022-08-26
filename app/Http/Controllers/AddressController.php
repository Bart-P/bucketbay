<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): Factory|View|Application
    {
        return view('addresses.index');
    }

    public function store(): RedirectResponse|Application|Redirector
    {
        if (!empty(auth()->user()->id)) {
            $user_id = (string) auth()->user()->id;
            $form_fields = request()->validate(['user_id'      => $user_id,
                                                'name1'        => ['required', Rule::unique('addresses', 'name1')],
                                                'name2'        => '',
                                                'name3'        => '',
                                                'street'       => 'required',
                                                'street_nr'    => 'required',
                                                'city'         => 'required',
                                                'city_code'    => 'required',
                                                'country'      => 'required',
                                                'address_info' => '',]);

            $form_fields['user_id'] = $user_id;
            Address::create($form_fields);

            return redirect('/addresses')->with('success_msg', 'Adresse hinzugefügt!');
        }

        return redirect('/addresses')->with('failed_msg', 'Adresse konnte nicht hinzugefügt werden!');
    }

    public function create(): Factory|View|Application
    {
        return view('addresses.create');
    }

    public function edit(Address $address): Factory|View|Application
    {
        return view('/addresses/edit', ['address' => $address]);
    }

    public function update(Address $address): Redirector|Application|RedirectResponse
    {
        $address_fields = request()->validate(['name1'        => 'required',
                                               'name2'        => '',
                                               'name3'        => '',
                                               'street'       => 'required',
                                               'street_nr'    => 'required',
                                               'city'         => 'required',
                                               'city_code'    => 'required',
                                               'country'      => 'required',
                                               'address_info' => '',]);

        $address->updateTimestamps();

        if ($address->update($address_fields)) {
            if (!empty($address->id) && $address->id == $this->cartService->getAddressId()) {
                $this->cartService->addAddressId($address->id);
            }

            return redirect('/addresses')->with('success_msg', 'Adresse erfolgreich bearbeitet!');
        }

        return redirect('/addresses')->with('failed_msg', 'Adresse konnte nicht bearbeitet werden!');
    }

    public function destroy($address_id): Redirector|RedirectResponse|Application
    {
        if (Address::destroy($address_id)) {
            if ($this->cartService->getAddressId() == $address_id) {
                $this->cartService->addAddressId(null);
            }

            return redirect('/addresses')->with('success_msg', 'Adresse wurde gelöscht!');
        }

        return redirect('/addresses')->with('failed_msg', 'Adresse konnte nicht gelöscht werden!');
    }
}