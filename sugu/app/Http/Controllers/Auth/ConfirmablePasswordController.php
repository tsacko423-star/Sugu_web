<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class ConfirmablePasswordController
{
    public function show()
    {
        return view('auth.confirm-password');
    }

    public function store(Request $request)
    {
        if (!password_verify($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => 'The password does not match our records.',
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
