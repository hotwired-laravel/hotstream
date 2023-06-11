<x-app-layout :title="__('Settings for :name', ['name' => $team->name])">
    <x-container :padding-on-native="false">
        <x-turbo-frame id="navigation-menu" target="_top">
            <x-back-link :href="route('accounts.index')">{{ __('Teams & Settings') }}</x-back-link>

            <x-page-heading>{{ __('Settings for :name', ['name' => $team->name]) }}</x-page-heading>

            <x-menu>
                <x-menu.section>
                    @unless (auth()->user()->currentTeam->is($team))
                    <x-menu.form-button :action="route('teams.current', $team)" method="PUT" icon="arrow-path" data-turbo-frame="_top">
                        {{ __('Switch To This Team') }}
                    </x-menu.form-button>
                    @endunless

                    @if (auth()->user()->can('update', $team))
                    <x-menu.link :href="route('teams.edit', $team)" icon="wrench" data-turbo-frame="_top">
                        {{ __('Edit Team Details') }}
                    </x-menu.link>
                    @endif

                    <x-menu.link :href="route('team-users.index', $team)" icon="users" data-turbo-frame="_top">
                        {{ __('Manage Team Members') }}
                    </x-menu.link>
                </x-menu.section>

                @if (Gate::check('delete', $team) && ! $team->personal_team)
                    <x-menu.section>
                        <x-menu.link :href="route('teams.delete', $team)" icon="trash" data-turbo-frame="_top">
                            {{ __('Delete Team') }}
                        </x-menu.link>
                    </x-menu.section>
                @endif
            </x-menu>
        </x-turbo-frame>
    </x-container>
</x-app-layout>
