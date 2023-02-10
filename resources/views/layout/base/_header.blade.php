{{-- Header --}}
<div id="kt_header" class="header {{ Metronic::printClasses('header', false) }}" {{ Metronic::printAttrs('header') }}>

    {{-- Container --}}
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        @if (config('website-layout.header.self.display'))

            @php
                $kt_logo_image = 'logo-light.png';
                if (config('website-layout.header.self.theme') === 'dark')
                {
                    $kt_logo_image = 'logo-dark.png';
                }
            @endphp

            {{-- Header Menu --}}
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                @if(config('website-layout.aside.self.display') == false)
                    <div class="header-logo">
                        <a href="{{ uA('/home') }}" title="{{ env('APP_NAME') }}">
                            <h1>tweets manage</h1>
                        </a>
                    </div>
                @endif

                <h2 class="text-dark font-weight-bold mb-0 mt-3">
                    {{ $moduleLabel }}
                    <span class="count mb-0"></span>
                </h2>

                @if (config('website-layout.subheader.displayDesc'))
                    <small class="text-black-50 font-size-sm">{{ $moduleDes }}</small>
                @endif

            </div>

        @else
            <div></div>
        @endif

        @include('layout.partials.extras._topbar')
    </div>
</div>
