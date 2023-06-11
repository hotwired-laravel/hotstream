@props(['size' => 'sm', 'paddingOnNative' => true])

@php
$maxSize = match ($size) {
    'sm' => 'max-w-2xl',
    'md' => 'max-w-4xl',
    'lg' => 'max-w-7xl',
    default => $size,
};
@endphp

<div class="py-6 sm:py-12 {{ $paddingOnNative ? '' : 'native:py-0' }}">
    <div class="{{ $maxSize }} mx-auto px-4 sm:px-6 lg:px-8 {{ $paddingOnNative ? '' : 'native:px-0' }}">
        {{ $slot }}
    </div>
</div>
