<?php

use App\Hotstream\Models\Team;
use Hotwired\Hotstream\Hotstream;
use Illuminate\Support\Facades\Gate;

beforeEach(function () {
    Gate::policy(Team::class, TeamPolicy::class);

    Hotstream::useUserModel(User::class);
});

test('team members can be added', function () {

});
