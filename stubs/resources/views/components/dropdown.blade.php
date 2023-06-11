@props(['align' => 'right', 'width' => '72', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700', 'dropdownClasses' => ''])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'none':
    case 'false':
        $alignmentClasses = '';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '72':
        $width = 'w-72';
        break;
    case '44':
        $width = 'w-44';
        break;
}
@endphp

<div {{ $attributes->merge([
    'class' => 'relative',
    'data-controller' => 'dropdown',
    'data-action' => 'click@window->dropdown#closeWhenClickedOutside',
]) }}>
    <div data-action="click->dropdown#toggle">
        {{ $trigger }}
    </div>

    <div
        data-dropdown-target="content"
        data-action="click->dropdown#closeWhenTargetTop"
        data-transition-enter="transition ease-out duration-200"
        data-transition-enter-start="transform opacity-0 scale-95"
        data-transition-enter-end="transform opacity-100 scale-100"
        data-transition-leave="transition ease-in duration-75"
        data-transition-leave-start="transform opacity-100 scale-100"
        data-transition-leave-end="transform opacity-0 scale-95"
        class="hidden absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} {{ $dropdownClasses }}"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
