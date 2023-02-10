@props([
'countClass' => 'text-white',
'count' => '',
'col' => 4,
'title' => '',
'icon' => '',
'backGroundClass' => 'bg-info ',
'iconsClass' => 'text-white',
'url' => ''
])
<div class="col-xl-{{ $col }}">
    <!--begin::Stats Widget 30-->
    <div class="card card-custom {{ $backGroundClass }} card-stretch gutter-b">
        <!--begin::Body-->
        <div class="card-body">
            <a href="{{$url}}" class="text-white">
                <i class="icon-2x {{ $iconsClass }} {{ $icon }} mr-3"></i>
                <span
                    class="card-title font-weight-bolder {{ $countClass }} font-size-h2 mb-0 mt-2 ">{{ $count }}</span>
                <span class="font-weight-light text-white  font-size-md d-block">{{ $title }}</span>
            </a>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Stats Widget 30-->
</div>
