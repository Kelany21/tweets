@if(config('website-layout.self.layout') == 'blank')
    <div class="d-flex flex-column flex-root" onmouseup="getSelectedText(['admin'])">
        @yield('content')
    </div>
@else

    @include('layout.base._header-mobile')
{{--    onmouseup="getSelectedText(['admin'])"--}}
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">

            @if(config('website-layout.aside.self.display'))
                @include('layout.base._aside')
            @endif

            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                @include('layout.base._header')

                <div class="content {{ Metronic::printClasses('content', false) }} d-flex flex-column flex-column-fluid"
                    id="kt_content">


                    @include('layout.base._content')
                </div>

                @include('layout.base._footer')
            </div>
        </div>
    </div>

@endif

@if (config('website-layout.self.layout') != 'blank')

    @if (config('website-layout.extras.search.layout') == 'offcanvas')
        @include('layout.partials.extras.offcanvas._quick-search')
    @endif

    @if (config('website-layout.extras.notifications.layout') == 'offcanvas')
        @include('layout.partials.extras.offcanvas._quick-notifications')
    @endif

    @if (config('website-layout.extras.quick-actions.layout') == 'offcanvas')
        @include('layout.partials.extras.offcanvas._quick-actions')
    @endif

    @if (config('website-layout.extras.user.layout') == 'offcanvas')
        @include('layout.partials.extras.offcanvas._quick-user')
    @endif

    @if (config('website-layout.extras.quick-panel.display'))
        @include('layout.partials.extras.offcanvas._quick-panel')
    @endif

    @if (config('website-layout.extras.toolbar.display'))
        @include('layout.partials.extras._toolbar')
    @endif

    @if (config('website-layout.extras.chat.display'))
        @include('layout.partials.extras._chat')
    @endif

    @include('layout.partials.extras._scrolltop')

@endif

