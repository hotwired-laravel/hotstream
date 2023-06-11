@props(['icon' => null])

<a {{ $attributes->merge([
    'class' => 'block dark:text-white px-4 py-3 native:p-4 text-base flex items-center justify-between space-x-4 transition hover:bg-gray-50 hover:dark:bg-gray-800',
]) }}>
    <span class="flex items-center space-x-4">
        @isset ($icon)
        <x-icon :icon="$icon" size="sm" />
        @endif
        <span>{{ $slot }}</span>
    </span>

    {{ $right ?? '' }}
</a>
