<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Contracts\UpdatesUserPictures;
use Hotwired\Hotstream\Hotstream;
use Illuminate\Http\Request;

class ProfilePictureController
{
    public function edit(Request $request)
    {
        abort_unless(Hotstream::managesProfilePhotos(), 403);

        return view('profile-picture.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request, UpdatesUserPictures $updater)
    {
        abort_unless(Hotstream::managesProfilePhotos(), 403);

        $updater->update($user = $request->user(), $request->all());

        if ($request->wantsTurboStream()) {
            return turbo_stream([
                turbo_stream()->update('user-profile', view('profile-picture._form', ['user' => $user])),
                turbo_stream()->replace('current-user-nav-photo', view('user._current_user_nav_photo', ['user' => $user])),
                turbo_stream()->replace('current-user-nav-photo-mobile', view('user._current_user_nav_photo', ['id' => 'current-user-nav-photo-mobile', 'class' => 'w-10 h-10', 'user' => $user])),
                turbo_stream()->flash(__('Profile photo updated.')),
            ]);
        }

        return redirect()->route('profile.picture.edit')->with('status', __('Profile photo updated.'));
    }

    public function destroy(Request $request)
    {
        abort_unless(Hotstream::managesProfilePhotos(), 403);

        $request->user()->deleteProfilePhoto();

        if ($request->wantsTurboStream()) {
            return turbo_stream([
                turbo_stream()->update('user-profile', view('profile-picture._form', ['user' => $request->user()])),
                turbo_stream()->replace('current-user-nav-photo', view('user._current_user_nav_photo', ['user' => $request->user()])),
                turbo_stream()->flash(__('Profile photo removed.')),
            ]);
        }

        return redirect()->route('profile.picture.edit')->with('status', __('Profile photo removed.'));
    }
}
