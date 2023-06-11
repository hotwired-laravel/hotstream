<div id="notifications" class="fixed top-10 left-0 right-0 flex flex-col items-center justify-center space-y-2 z-10 opacity-80">
    @if (session()->has('status'))
        @include('layouts._notification', ['message' => session('status')])
    @endif
</div>
