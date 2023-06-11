<x-app-layout :title="__('Edit Profile')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('Edit Profile') }}</x-page-heading>

        <x-form-card>
            @if (Hotwired\Hotstream\Hotstream::managesProfilePhotos())
            <x-turbo-frame class="mb-6 block transition" id="user-profile">
                @include('user-picture._form', ['user' => $user])
            </x-turbo-frame>

            <hr class="w-1/4 mx-auto my-6" />
            @endif

            <p class="native:hidden mb-6 text-sm dark:text-gray-400">
                {{ __('Update your account\'s profile information and email address.') }}</p>

            <form method="POST" action="{{ route('user.update') }}">
                @csrf
                @method('PUT')

                <div class="mt-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email"
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
