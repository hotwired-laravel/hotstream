<x-app-layout :title="__('Edit Profile Photo')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('Edit Profile Photo') }}</x-page-heading>

        <x-form-card>
            <x-turbo-frame id="user-profile" target="_top" class="contents">
                @include('profile-picture._form', ['user' => $user])
            </x-turbo-frame>
        </x-form-card>
    </x-container>
</x-app-layout>
