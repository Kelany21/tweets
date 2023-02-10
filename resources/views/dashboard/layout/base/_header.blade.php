{{-- Header --}}
<div id="kt_header" class="header {{ Metronic::printClasses('header', false) }}" {{ Metronic::printAttrs('header') }}>

    {{-- Container --}}
    <div class="container-fluid d-flex align-items-center justify-content-between">
        @if (config('layout.header.self.display'))

            @php
                $kt_logo_image = 'logo-light.png';
            @endphp

            @if (config('layout.header.self.theme') === 'light')
                @php $kt_logo_image = 'logo-dark.png' @endphp
            @elseif (config('layout.header.self.theme') === 'dark')
                @php $kt_logo_image = 'logo-light.png' @endphp
            @endif

            {{-- Header Menu --}}
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                @if(config('layout.aside.self.display') == false)
                    <div class="header-logo">
                        <a href="{{ uA('/dashboard/home') }}" title="{{ env('APP_NAME') }}">
                            <img alt="Logo" src="{{ asset('media/logos/'.$kt_logo_image) }}"/>
                        </a>
                    </div>
                @endif

                <h2 class="text-dark font-weight-bold mb-0 mt-3">
                    <i class="{{ $moduleIcon }} icon-lg-xl"></i> {{ $moduleLabel }}
                    <span class="count mb-0"></span>
                </h2>

                @if (isset($moduleDes) && config('layout.subheader.displayDesc'))
                    <small class="text-black-50 font-size-sm">{{ $moduleDes }}</small>
                @endif

            </div>

        @else
            <div></div>
        @endif

        @include('dashboard.layout.partials.extras._topbar')
    </div>
</div>
