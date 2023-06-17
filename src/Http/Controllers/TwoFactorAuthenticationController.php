<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class TwoFactorAuthenticationController
{
    public function index()
    {
        return view('two-factor-authentication.index');
    }

    public function destroy(Request $request, DisableTwoFactorAuthentication $disable)
    {
        $disable($request->user());

        return redirect()->route('two-factor-authentication.index')->with('status', __('Two factor authentication disabled.'));
    }
}
