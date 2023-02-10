@if(!request()->has('delete'))
    <div class="row mb-6">
        {{ $slot }}
    </div>
@endif


