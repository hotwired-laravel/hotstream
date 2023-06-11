<?php

namespace Hotwired\Hotstream\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class PasswordController extends Controller
{
    use RedirectsActions;

    public function edit()
    {
        return view('password.edit');
    }

    public function update(Request $request, UpdatesUserPasswords $updater)
    {
        $updater->update($request->user(), $request->all());

        return back()->with('status', __('Password changed.'));
    }
}
