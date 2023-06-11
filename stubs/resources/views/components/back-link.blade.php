@props(['href', 'onlyVisibleInFrame' => true])

@php
$visibilityClasses = $onlyVisibleInFrame
    ? 'hidden in-frame:flex in-frame:justify-start in-frame:mb-0 in-frame:mb-2'
    : 'flex justify-center items-center';
@endphp

<div class="mb-6 {{ $visibilityClasses }} native:hidden">
    <a href="{{ $href }}" class="inline-flex items-center px-4 py-2 space-x-2 text-sm font-semibold in-frame:w-full dark:text-gray-400 hover:dark:bg-gray-800">
        <x-icon icon="arrow-long-left" />
        <span>{{ $slot }}</span>
    </a>
</div>
