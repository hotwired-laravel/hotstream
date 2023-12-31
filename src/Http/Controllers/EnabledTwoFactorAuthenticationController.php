<?php

namespace HotwiredLaravel\Hotstream\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class EnabledTwoFactorAuthenticationController
{
    public function store(Request $request, EnableTwoFactorAuthentication $enabler)
    {
        if ($request->user()->hasEnabledTwoFactorAuthentication()) {
            return redirect()->route('two-factor-authentication.index');
        }

        $enabler($request->user());

        return redirect()->route('confirmed-two-factor-authentication.create');
    }
}
