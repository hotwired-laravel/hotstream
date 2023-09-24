@if (session('createdToken'))
    <div class="my-6" data-turbo-temporary>
        <div class="text-center text-gray-800 dark:text-gray-400">
            {{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}
        </div>

        <x-input type="text" readonly :value="decrypt(session('createdToken'))"
            class="w-full px-4 py-2 mt-4 font-mono text-sm text-gray-500 break-all bg-gray-100 rounded"
            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
            data-controller="autoselect"
        />
    </div>
@endif
