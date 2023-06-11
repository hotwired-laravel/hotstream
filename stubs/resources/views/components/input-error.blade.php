@props(['for', 'bag' => 'default'])

@error($for, $bag)
    <p {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400']) }} data-turbo-temporary>{{ $message }}</p>
@enderror
