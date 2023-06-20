<x-app-layout :title="__('Change Token Permission')">
    <x-container>
        <x-back-link :href="route('api-tokens.index')" :only-visible-in-frame="false">
            {{ __('API Tokens') }}
        </x-back-link>

        <x-page-heading>{{ __('Change Token Permission') }}</x-page-heading>

        <x-form-card>
            <form id="@domid($token)" method="POST" action="{{ route('api-tokens.update', $token) }}">
                @csrf
                @method('PUT')

                <div>
                    <p class="dark:text-gray-400">{{ __('Changing permission for :name.', ['name' => $token->name]) }}</p>
                </div>

                <!-- Token Permissions -->
                @if (HotwiredLaravel\Hotstream\Hotstream::hasPermissions())
                    <div class="col-span-6 mt-4">
                        <x-label for="permissions" value="{{ __('Permissions') }}" />

                        <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
                            @foreach (HotwiredLaravel\Hotstream\Hotstream::$permissions as $permission)
                                <label class="flex items-center">
                                    <x-checkbox name="permissions[]" :value="$permission" :checked="in_array($permission, $token->abilities)" />
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $permission }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-form-card>
    </x-container>
</x-app-layout>
