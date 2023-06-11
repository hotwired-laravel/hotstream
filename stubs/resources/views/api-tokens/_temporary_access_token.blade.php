@if (session('createdToken'))
    <div class="mb-6" data-turbo-temporary>
        <div class="text-gray-600 dark:text-gray-400">
            {{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}
        </div>

        <x-input type="text" readonly :value="decrypt(session('createdToken'))"
            class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
            autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
            data-controller="autoselect"
        />
    </div>
@endif
