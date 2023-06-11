@props(['method' => 'POST', 'action', 'icon' => null])
<form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}">
    @csrf

    @if (! in_array($method, ['POST', 'GET']))
        @method($method)
    @endif

    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full block dark:text-white px-4 py-3 native:p-4 text-base flex items-center justify-start space-x-4 transition hover:bg-gray-50 hover:dark:bg-gray-800']) }}>
        @isset ($icon)
        <x-icon :icon="$icon" size="sm" />
        @endisset

        <span>{{ $slot }}</span>
    </button>
</form>
