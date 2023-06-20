<?php

use HotwiringLaravel\Hotstream\Features;

return [
    'middleware' => ['web'],
    'features' => [Features::accountDeletion()],
    'profile_photo_disk' => 'public',
];
