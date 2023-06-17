<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;

class RecoveryCodesController
{
    public function index()
    {
        return view('recovery-codes.index');
    }

    public function store(Request $request, GenerateNewRecoveryCodes $regenerate)
    {
        $regenerate($request->user());

        return redirect()->route('recovery-codes.index');
    }
}
