@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

<div
    data-controller="banner reveal"
    data-reveal-show-value="@js(boolval($message))"
    data-banner-style-value="@js($style)"
    data-banner-message-value="@js($message)"
    data-banner-success-class="bg-indigo-500"
    data-banner-danger-class="bg-red-700"
    data-banner-default-class="bg-gray-500"
    data-banner-button-success-class="hover:bg-indigo-600 focus:bg-indigo-600"
    data-banner-button-danger-class="hover:bg-red-600 focus:bg-red-600"
    data-banner-icon-success-class="bg-indigo-600"
    data-banner-icon-danger-class="bg-red-600"
    data-action="banner-message@window->banner#setMessage banner-message@window->reveal#show"
    class="hidden"
>
    <div class="max-w-screen-xl px-3 py-2 mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between">
            <div class="flex items-center flex-1 w-0 min-w-0">
                <span
                    class="flex p-2 rounded-lg"
                    data-banner-target="icon"
                >
                    <svg data-style="success" class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg data-style="danger" class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <svg data-style="default" class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </span>

                <p data-banner-target="content" class="ml-3 text-sm font-medium text-white truncate"></p>
            </div>

            <div class="shrink-0 sm:ml-3">
                <button
                    type="button"
                    class="flex p-2 -mr-1 transition rounded-md focus:outline-none sm:-mr-2"
                    data-banner-target="button"
                    aria-label="Dismiss"
                    data-action="click->reveal#hide"
                >
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
