<x-app-layout :title="__('API Tokens')">
    <x-container>
        <x-back-link :href="route('accounts.index')">
            {{ __('Teams & Settings') }}
        </x-back-link>

        <x-page-heading>{{ __('API Tokens') }}</x-page-heading>

        <x-card-section size="lg">
            <div class="flex items-center justify-end space-x-4">
                <x-button-link :href="route('api-tokens.create')" class="flex items-center space-x-2">
                    {{ __('Create Token') }}
                </x-button-link>
            </div>

            @include('api-tokens._temporary_access_token')

            <div class="mt-6 space-y-6">
                @if ($tokens->isEmpty())
                <div class="hidden only:block">
                    <p class="text-center dark:text-gray-400">{{ __('No tokens yet.') }}</p>
                </div>
                @endif

                @foreach ($tokens as $token)
                    <div class="flex items-center justify-between">
                        <div class="break-all dark:text-white">
                            {{ $token->name }}
                        </div>

                        <div class="flex items-center ml-2">
                            @if ($token->last_used_at)
                                <div class="text-sm text-gray-400">
                                    {{ __('Last used') }} {{ $token->last_used_at->diffForHumans() }}
                                </div>
                            @endif

                            @if (HotwiredLaravel\Hotstream\Hotstream::hasPermissions())
                                <a href="{{ route('api-tokens.edit', $token) }}" class="cursor-pointer ml-6 text-sm text-gray-400 underline">
                                    {{ __('Permissions') }}
                                </a>
                            @endif

                            <form action="{{ route('api-tokens.destroy', $token) }}" method="POST" data-turbo-confirm="{{ __('Are you sure you want to delete this token?') }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="cursor-pointer ml-6 text-sm text-red-500">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card-section>
    </x-container>
</x-app-layout>
