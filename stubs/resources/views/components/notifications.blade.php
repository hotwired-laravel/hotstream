<div id="notifications" class="fixed left-0 right-0 z-10 flex flex-col items-center justify-center space-y-2 top-10 opacity-80">
    @if (session()->has('status'))
        @include('layouts._notification', ['message' => session('status')])
    @endif
</div>
