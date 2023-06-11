<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;

class RecoveryCodesController extends Controller
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
