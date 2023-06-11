@props(['size' => 'md'])

@php
$sizeClass = match ($size) {
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    default => $size,
}
@endphp

<div {{ $attributes->merge(['class' => 'px-2 sm:px-0 flex justify-center bg-gray-100 dark:bg-gray-900']) }}>
    <div class="w-full {{ $sizeClass }} px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden">
        {{ $slot }}
    </div>
</div>
