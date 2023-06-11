<form class="flex items-center justify-start [form[aria-busy=true]_&]:animate-pulse" action="{{ route('user.picture.destroy') }}" method="POST" data-turbo-confirm="{{ __('Are you sure you want to remove your photo?') }}">
    @csrf
    @method('DELETE')

    <button type="submit" class="text-red-700 hover:text-red-600 text-sm underline underline-offset-4" data-turbo-submit-with="{{ __('Removing...') }}">{{ __('Remove photo') }}</button>
</form>
