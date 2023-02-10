@if(config('layout.self.layout') == 'blank')
    <div class="d-flex flex-column flex-root" onmouseup="getSelectedText(['admin'])">
        @yield('content')
    </div>
@else

    @include('dashboard.layout.base._header-mobile')
{{--    onmouseup="getSelectedText(['admin'])"--}}
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">

            @if(config('layout.aside.self.display'))
                @include('dashboard.layout.base._aside')
            @endif

            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                @include('dashboard.layout.base._header')

                <div
                    class="content {{ Metronic::printClasses('content', false) }} d-flex flex-column flex-column-fluid"
                    id="kt_content">


                    @include('dashboard.layout.base._content')
                </div>

                @include('dashboard.layout.base._footer')
            </div>
        </div>
    </div>

@endif

@if (config('layout.self.layout') != 'blank')

    @if (config('layout.extras.search.layout') == 'offcanvas')
        @include('dashboard.layout.partials.extras.offcanvas._quick-search')
    @endif

    @if (config('layout.extras.notifications.layout') == 'offcanvas')
        @include('dashboard.layout.partials.extras.offcanvas._quick-notifications')
    @endif

    @if (config('layout.extras.quick-actions.layout') == 'offcanvas')
        @include('dashboard.layout.partials.extras.offcanvas._quick-actions')
    @endif

    @if (config('layout.extras.user.layout') == 'offcanvas')
        @include('dashboard.layout.partials.extras.offcanvas._quick-user')
    @endif

    @if (config('layout.extras.quick-panel.display'))
        @include('dashboard.layout.partials.extras.offcanvas._quick-panel')
    @endif

    @if (config('layout.extras.toolbar.display'))
        @include('dashboard.layout.partials.extras._toolbar')
    @endif

    @if (config('layout.extras.chat.display'))
        @include('dashboard.layout.partials.extras._chat')
    @endif

    @include('dashboard.layout.partials.extras._scrolltop')

@endif

