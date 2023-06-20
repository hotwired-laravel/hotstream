<?php

namespace App\Actions\Hotstream;

use App\Models\User;
use HotwiredLaravel\Hotstream\Contracts\UpdatesUserPictures;
use Illuminate\Support\Facades\Validator;

class UpdateUserPicture implements UpdatesUserPictures
{
    public function update(User $user, array $input, bool $requirePhoto = true): void
    {
        Validator::make($input, [
            'photo' => [$requirePhoto ? 'required' : 'nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validate();

        if ($input['photo'] ?? false) {
            $user->updateProfilePhoto($input['photo']);
        }
    }
}
