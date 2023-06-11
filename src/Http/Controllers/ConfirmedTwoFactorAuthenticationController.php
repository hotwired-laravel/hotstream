<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;

class ConfirmedTwoFactorAuthenticationController extends Controller
{
    public function create()
    {
        return view('confirmed-two-factor-authentication.create');
    }

    public function store(Request $request, ConfirmTwoFactorAuthentication $confirm)
    {
        $confirm($request->user(), $request->input('code'));

        return redirect()->route('two-factor-authentication.index')
            ->with('showRecoveryCodes', true)
            ->with('status', __('Two factor authentication enabled.'));
    }
}
