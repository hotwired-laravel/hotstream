<?php

namespace Hotwired\Hotstream\Http\Controllers;

use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    public function index()
    {
        return view('accounts.index');
    }
}
