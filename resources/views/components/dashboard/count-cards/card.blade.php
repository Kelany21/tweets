@props([
    'countClass' => '',
    'count' => '',
    'col' => 4,
    'title' => '',
    'icon' => '',
    'waveClass' => 'wave-success',
    'iconsClass' => 'text-success'
])
<div class="col-lg-{{ $col }}">
    <div class="card card-custom wave wave-animate-fast {{ $waveClass }}">
        <div class="card-body pl-3 pr-3 pt-4 pb-4">
            <div class="d-flex align-items-center">
                <div class="mr-4">
                    <i class="{{ $icon }} icon-xl-2x  font-weight-bold {{ $iconsClass }}"></i>
                </div>
                <div class="d-flex flex-column">
                    <a href="#" class="text-dark text-hover-primary  font-size-h6 mb-3">
                        <p>{{ $title  }}</p>
                    </a>
                    <h5 class="text-dark-75 {{ $countClass }}">{{ $count }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
