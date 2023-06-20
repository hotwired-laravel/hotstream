<x-app-layout :title="__('Create API Token')">
    <x-container>
        <x-back-link :href="route('api-tokens.index')" :only-visible-in-frame="false">
            {{ __('API Tokens') }}
        </x-back-link>

        <x-page-heading>{{ __('Invite Someone') }}</x-page-heading>

        <x-form-card>
            <form method="POST" action="{{ route('api-tokens.store') }}">
                @csrf
                <!-- Token Name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="name" value="{{ __('Token Name') }}" />
                    <x-input id="name" type="text" class="block w-full mt-1" name="name" autofocus />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <!-- Token Permissions -->
                @if (HotwiringLaravel\Hotstream\Hotstream::hasPermissions())
                    <div class="col-span-6 mt-4">
                        <x-label for="permissions" value="{{ __('Permissions') }}" />

                        <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
                            @foreach (HotwiringLaravel\Hotstream\Hotstream::$permissions as $permission)
                                <label class="flex items-center">
                                    <x-checkbox name="permissions[]" :value="$permission"/>
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $permission }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Create Token') }}
                    </x-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
