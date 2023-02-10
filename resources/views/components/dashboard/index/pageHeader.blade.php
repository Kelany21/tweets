<div class="card card-custom">
    <div class="card-header flex-wrap pt-6 pb-6">
        <div class="card-title">
            <h1 class="card-label font-size-h2"><i class="{{ $moduleIcon }} icon-2x"></i> {{ $title }} <span class="count"></span>
                <div class="text-muted pt-2 font-size-sm">{{ $moduleDes }}</div>
            </h1>
        </div>
        {{ $slot }}
    </div>
</div>
