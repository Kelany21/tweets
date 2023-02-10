 <!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }} {{ Metronic::printClasses('html') }} dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title Section --}}
    <title>Tweet Manage | @yield('title', $page_title ?? '')</title>

    {{-- Meta Data --}}
    <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}"/>

    {{-- Fonts --}}
{{--    {{ Metronic::getGoogleFontsInclude() }}--}}

    {{-- Global Theme Styles (used by all pages) --}}
    @foreach(config('layout.resources.css') as $style)
        <link href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? asset(Metronic::rtlCssPath($style)) : asset($style) }}"
              rel="stylesheet" type="text/css"/>
    @endforeach

    {{-- Layout Themes (used by all pages) --}}
    @foreach (Metronic::initThemes() as $theme)
        <link href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() === 'rtl' ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}"
              rel="stylesheet" type="text/css"/>
    @endforeach
{{--    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&family=Tajawal:wght@300&display=swap"--}}
{{--          rel="stylesheet">--}}

{{--    <link href="{{ url('assets/abdelaziz.css') }}" rel="stylesheet" type="text/css"/>--}}


    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    {{-- Includable CSS --}}
    @yield('styles')

    @stack('css')
</head>

<body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }} >

@if (config('layout.page-loader.type') != '')
    @include('dashboard.layout.partials._page-loader')
@endif

@include('dashboard.layout.base._layout')

<!--- upload model -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenter"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div style="height: 800px;">
                <div id="fm"></div>
            </div>
        </div>
    </div>
</div>
<!--- end upload model -->
<script>var HOST_URL = "{{ route('quick-search') }}";</script>

{{-- Global Config (global config for global JS scripts) --}}
<script>
    var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
</script>

{{-- Global Theme JS Bundle (used by all pages)  --}}
@foreach(config('layout.resources.js') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
@endforeach

@include('components.dashboard.js.date')

{{-- Includable JS --}}
@yield('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@stack('scripts')

<script>
    @if(request()->session()->has('alert'))
    @php
        $alert = request()->session()->get('alert') ;
        $alert['rtl'] = false;
        $alert['positionClass'] = "toast-top-right";
        if(app()->getLocale() === 'ar'){
            $alert['rtl'] = true;
            $alert['positionClass'] = "toast-top-left";
        }
    @endphp
    toastr.{{$alert['type']}}("{{ $alert['title'] }}", "{{$alert['message']}}", {
        rtl: {{  $alert['rtl'] }},
        positionClass: '{{ $alert['positionClass'] }}'
    });
    @endif
</script>
<script>
    var inputUpdate = null;

    showCancelBtns();

    function openUploadModel(e) {
        inputUpdate = $(e).closest('div.input-group').find('input.hiddenInput');
        $('#exampleModalCenter').modal('show')
    }

    function fmSetLink(url) {
        $(inputUpdate).val(url);
        $(inputUpdate).closest('div.input-group').find('img').attr('src', url);
        $(inputUpdate).closest('div.input-group').find('.cancel-image').attr('style', 'display:block')
    }

    fm.$store.commit('fm/setFileCallBack', function (fileUrl) {
        $(inputUpdate).closest('div.input-group').find('img').removeAttr('src')
        fmSetLink(fileUrl);
        $('#exampleModalCenter').modal('hide')
    });

    function showCancelBtns() {
        $('.hiddenInput').each(function (e, t) {
            $(t).closest('div.input-group').find('.cancel-image').attr('style', 'display:block');
        });
    }

    function cancelImage(e) {
        $(e).closest('div.input-group').find('img').attr('src', '{{ defaultImage() }}');
        $(e).closest('div.input-group').find('input.hiddenInput').val('');
    }
</script>
</body>
</html>

