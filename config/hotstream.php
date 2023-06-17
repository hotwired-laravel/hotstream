<?php

use Hotwired\Hotstream\Features;

return [
    'middleware' => ['web'],
    'features' => [Features::accountDeletion()],
    'profile_photo_disk' => 'public',
];
