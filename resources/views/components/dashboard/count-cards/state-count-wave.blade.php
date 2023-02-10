@props([
'countClass' => 'text-dark',
'count' => '',
'col' => 4,
'title' => '',
'icon' => '',
'color' => 'info',
'iconsClass' => 'text-dark',
'url' => ''
])
<div class="col-xl-{{ $col }}">
    <!--begin::Stats Widget 30-->
    <div class="card card-custom wave wave-animate-fast wave-{{ $color }}">
        <!--begin::Body-->
        <div class="card-body pl-3 pr-3 pt-4 pb-4">
            <a {{$url ? 'href="' . $url . '"' : ''}}>
                <i class="icon-2x {{ $iconsClass }} {{ $icon }} mr-3"></i>
                <span
                    class="card-title font-weight-bolder {{ $countClass }} font-size-h2 mb-0 mt-2">{{ $count }}</span>
                <span class="font-weight-light  font-size-md d-block text-dark">{{ $title }}</span>
            </a>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Stats Widget 30-->
</div>
