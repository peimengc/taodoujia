<div class="container px-0">
    @if (session('alert'))
        <div class="alert alert-{{ session('alert.type') }}" role="alert">
            {{ session('alert.content') }}
        </div>
    @endif
</div>
