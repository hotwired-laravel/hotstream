<div>
    <div class="flex items-start space-x-6">
        <div>
            <img class="h-16 w-16 object-cover rounded-full mb-2 [[aria-busy=true]_&]:animate-pulse"
                src="{{ $user->profile_photo_url }}"
                alt="{{ __('Current profile photo') }}" />
        </div>

        <div>
            <p class="mb-2 text-sm dark:text-gray-400">
                {{ __('Update your account\'s profile photo.') }}</p>

            <div class="items-center space-y-2 md:flex md:space-y-0 md:space-x-3">
                <form data-controller="autosubmitter" method="POST" action="{{ route('profile.picture.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="photo" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                        <span class="text-xs leading-normal [form[aria-busy=true]_&]:hidden">{{ __('Upload photo') }}</span>
                        <span class="text-xs leading-normal hidden animate-pulse [form[aria-busy=true]_&]:inline" aria-hidden="true">{{ __('Uploading...') }}</span>
                        <input
                            id="photo"
                            type="file"
                            class="hidden"
                            name="photo"
                            data-autosubmitter-target="input"
                            data-action="change->autosubmitter#submit"
                        />
                    </label>
                    <x-input-error for="photo" class="mt-2" />
                    <button data-autosubmitter-target="submit" type="submit" hidden>{{ __('Save') }}</button>
                    <noscript>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </noscript>
                </form>

                @if ($user->profile_photo_path)
                    @include('profile-picture._delete_form')
                @endif
            </div>
        </div>
    </div>
</div>
