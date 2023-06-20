<x-app-layout :title="__('Edit Profile')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('Edit Profile') }}</x-page-heading>

        <x-form-card>
            @if (HotwiredLaravel\Hotstream\Hotstream::managesProfilePhotos())
            <x-turbo-frame class="block mb-6 transition" id="user-profile">
                @include('profile-picture._form', ['user' => $user])
            </x-turbo-frame>

            <hr class="w-1/4 mx-auto my-6" />
            @endif

            <p class="mb-6 text-sm native:hidden dark:text-gray-400">
                {{ __('Update your account\'s profile information and email address.') }}</p>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block w-full mt-1" type="text" name="name"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block w-full mt-1" type="email" name="email"
                        :value="old('email', $user->email)" required autocomplete="email" />
                    <x-input-error for="email" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
