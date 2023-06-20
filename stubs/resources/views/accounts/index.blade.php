<x-app-layout :title="__('Teams & Settings')">
    <x-container :padding-on-native="false">
        <x-turbo-frame id="navigation-menu" target="_top">
            <x-page-heading>
                {{ __('Teams & Settings') }}
            </x-page-heading>

            <x-menu>
                @if (HotwiringLaravel\Hotstream\Hotstream::hasTeamFeatures())
                <x-menu.section>
                    @foreach (auth()->user()->allTeams() as $team)
                        <x-menu.link :href="route('teams.show', $team)">
                            <span class="flex items-center space-x-2">
                                <span>{{ $team->name }}</span>
                                @if (auth()->user()->currentTeam->is($team))
                                <x-icon icon="check-badge" size="sm" />
                                @endif
                            </span>
                            <x-slot name="right"><x-icon icon="chevron-right" size="sm" /></x-slot>
                        </x-menu.link>
                    @endforeach

                    <x-menu.link :href="route('teams.create')" icon="plus" data-turbo-frame="_top">
                        {{ __('Create Another Team') }}</span>
                    </x-menu.link>
                </x-menu.section>
                @endif

                <x-menu.section>
                    <x-menu.link :href="route('profile.edit')" icon="user" data-turbo-frame="_top">
                        {{ __('Edit Profile') }}</span>
                    </x-menu.link>

                    <x-menu.link :href="route('profile.password.edit')" icon="key" data-turbo-frame="_top">
                        {{ __('Change Password') }}</span>
                    </x-menu.link>

                    @if (HotwiringLaravel\Hotstream\Hotstream::hasApiFeatures())
                    <x-menu.link href="{{ route('api-tokens.index') }}" icon="arrow-left-on-rectangle" data-turbo-frame="_top">
                        {{ __('API Tokens') }}
                    </x-menu.link>
                    @endif

                    <x-menu.link :href="route('two-factor-authentication.index')" icon="device-phone-mobile" data-turbo-frame="_top">
                        {{ __('Two Factor Authentication') }}</span>
                    </x-menu.link>

                    <x-menu.link :href="route('device-sessions.index')" icon="computer-desktop" data-turbo-frame="_top">
                        {{ __('Devices & Sessions') }}</span>
                    </x-menu.link>

                    <x-menu.link :href="route('profile.delete')" icon="trash" data-turbo-frame="_top">
                        {{ __('Delete Account') }}</span>
                    </x-menu.link>
                </x-menu.section>

                <x-menu.section>
                    <x-menu.form-button :action="route('logout')" icon="arrow-right-on-rectangle" data-turbo-frame="_top" data-turbo-action="replace">
                        {{ __('Logout') }}
                    </x-menu.form-button>
                </x-menu.section>
            </x-menu>
        </x-turbo-frame>
    </x-container>
</x-app-layout>
