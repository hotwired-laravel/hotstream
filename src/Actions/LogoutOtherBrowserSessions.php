<?php

namespace HotwiringLaravel\Hotstream\Actions;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LogoutOtherBrowserSessions
{
    public function __invoke(StatefulGuard $guard, string $password)
    {
        if (! Hash::check($password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        if (config('session.driver') !== 'database') {
            return;
        }

        $guard->logoutOtherDevices($password);

        $this->deleteOtherSessionRecords();

        request()->session()->put([
            'password_hash_'.Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        ]);
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @return void
     */
    protected function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }
}
