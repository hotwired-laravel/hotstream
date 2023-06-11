<img id="{{ $id ?? 'current-user-nav-photo' }}" class="{{ $class ?? 'h-8 w-8' }} rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
