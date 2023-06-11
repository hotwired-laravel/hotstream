<?php

namespace Hotwired\Hotstream\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        return view('accounts.index', [
            'teams' => $request->user()->allTeams(),
        ]);
    }
}
