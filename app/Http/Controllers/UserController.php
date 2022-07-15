<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function login()
    {
        return view('users.login');
    }

    public function authenticate()
    {
        $formFileds = request()->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (auth()->attempt($formFileds, true)) {
            request()->session()->regenerate();

            return redirect('/')->with('success_msg', 'Nutzer login erfolgreich!');
        }

        return back()->withErrors(['email' => 'Falsche zugangsdaten!']);
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }

    // TODO create edit user page for the user to change invoice address, change mail, password etc.
    // TODO also reset password link? Is there a package to handle that?
}
