<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Actions\LogoutOtherBrowserSessions;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;

class DeletedDeviceSessionsController
{
    public function edit()
    {
        return view('deleted-device-sessions.edit');
    }

    public function update(Request $request, StatefulGuard $guard, LogoutOtherBrowserSessions $logout)
    {
        $logout($guard, (string) $request->input('password'));

        return redirect()->route('device-sessions.index')->with('status', __('All other sessions removed.'));
    }
}
