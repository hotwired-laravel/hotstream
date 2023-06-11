<?php

namespace Hotwired\Hotstream\Http\Controllers;

use App\Http\Controllers\Controller;
use Hotwired\Hotstream\Contracts\DeletesUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Tonysm\TurboLaravel\Http\Controllers\Concerns\InteractsWithTurboNativeNavigation;

class UserController extends Controller
{
    use RedirectsActions;
    use InteractsWithTurboNativeNavigation;

    public function edit(Request $request)
    {
        return view('user.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request, UpdatesUserProfileInformation $updater)
    {
        $updater->update($request->user(), $request->all());

        return back()->with('status', __('Profile updated.'));
    }

    public function delete()
    {
        return view('user.delete');
    }

    public function destroy(Request $request, DeletesUsers $deleter, StatefulGuard $auth)
    {
        if (! Hash::check($request->input('password'), $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        $deleter->delete($request->user()->fresh());

        $auth->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect(config('fortify.redirects.logout') ?? '/');
    }
}
