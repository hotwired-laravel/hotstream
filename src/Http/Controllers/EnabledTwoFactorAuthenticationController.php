<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class EnabledTwoFactorAuthenticationController extends Controller
{
    public function store(Request $request, EnableTwoFactorAuthentication $enabler)
    {
        if (auth()->user()->hasEnabledTwoFactorAuthentication()) {
            return redirect()->route('two-factor-authentication.index');
        }

        $enabler($request->user());

        return redirect()->route('confirmed-two-factor-authentication.create');
    }
}
