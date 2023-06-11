<x-app-layout :title="__('Change Member Role')">
    <x-container>
        <x-back-link :href="route('team-users.index', $team)" :only-visible-in-frame="false">
            {{ __('Members of :name', ['name' => $team->name]) }}
        </x-back-link>

        <x-page-heading>{{ __('Change Member Role') }}</x-page-heading>

        <x-form-card>
            <form method="POST" action="{{ route('teams.team-users.role.update', [$team, $user]) }}">
                @csrf
                @method('PUT')

                <div>
                    <p class="dark:text-gray-400">{{ __('Changing role of :name.', ['name' => $user->name]) }}</p>
                </div>

                <!-- Role -->
                @if (count($roles) > 0)
                    <div class="col-span-6 mt-4 lg:col-span-4">
                        <x-label for="role" value="{{ __('Role') }}" />
                        <x-input-error for="role" class="mt-2" />

                        <div data-controller="radio-button" data-radio-button-selected-class="is-selected" class="relative z-0 mt-1 bg-white border border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 dark:bg-gray-800">
                            <input data-radio-button-target="input" type="hidden" name="role" value="{{ old('role', $user->membership->role) }}" />

                            @foreach ($roles as $index => $role)
                                <button type="button" data-action="radio-button#select" data-radio-button-target="button" data-radio-value="{{ $role->key }}" for="role-{{ $role->key }}" class="block cursor-pointer relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 {{ $index > 0 ? 'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}">
                                    <div class="opacity-50 is-selected:opacity-100">
                                        <!-- Role Name -->
                                        <div class="flex items-center">
                                            <div class="text-sm text-gray-600 dark:text-gray-400 {{ old('role') == $role->key ? 'font-semibold' : '' }}">
                                                {{ $role->name }}
                                            </div>

                                            <svg class="hidden w-5 h-5 ml-2 text-green-400 is-selected:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>

                                        <!-- Role Description -->
                                        <div class="mt-2 text-xs text-left text-gray-600 dark:text-gray-400">
                                            {{ $role->description }}
                                        </div>
                                    </div>
                                </button>
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
