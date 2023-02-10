@if ($errors->any())
    <div class="card card-custom mb-6 bg-diagonal-danger">
        <div class="card card-body bg-light-danger">
            <h5 class="mb-4">{{ trans('admin.you-have') }} {{ $errors->count() }} {{ trans('admin.please-fix-them-first') }}</h5>
            @foreach ($errors->all() as $index => $error)
                <p class="text-danger mt-0 mb-2">{{ $index+1  }} . {{ $error }}</p>
            @endforeach
        </div>
    </div>
    {{ $slot }}
@endif
