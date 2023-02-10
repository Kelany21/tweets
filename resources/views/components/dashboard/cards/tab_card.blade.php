@php
    $allowInEdit = isset($data['showOnEdit']) ? $data['showOnEdit']: true;
    $allowInCreate= isset($data['showOnCreate']) ? $data['showOnCreate'] : true;
@endphp
@if(($allowInEdit && $action == 'edit') || ($allowInCreate && $action == 'create') || $action == 'list')
    <div class="@isset($data['class']) {{ $data['class'] }}@endisset"
         id="@isset($data['id']) {{ $data['id'] }} @endisset ">
        <div
            class="card card-custom @isset($data['card-sticky']) card-sticky @endisset @isset($data['sticky']) sticky @endisset"
            @isset($data['sticky']) data-sticky="true" data-margin-top="140px" data-sticky-for="1023"
            data-sticky-class="sticky" @endisset  id="{{ isset($data['card-sticky']) ? 'kt_page_sticky_card' : '' }}">
            <div class="card-header card-header-tabs-line">
                <div class="card-toolbar">
                    @include('components.dashboard.tabs.header' , ['data' => $data['body']['tabs']])
                </div>
            </div>
            <div class="card-body @isset($data['body']['class']) {{ $data['body']['class'] }}@endisset"
                 id="@isset($data['body']['id']) {{ $data['body']['id'] }}@endisset">
                <div class="tab-content">
                    @foreach($data['body']['tabs'] as $tab)
                        @php
                            $allowInEditInTab = isset($tab['showOnEdit']) ? $tab['showOnEdit']: true;
                            $allowInCreateInTab = isset($tab['showOnCreate']) ? $tab['showOnCreate'] : true;
                        @endphp
                        @if(($allowInEditInTab && $action == 'edit') || ($allowInCreateInTab && $action == 'create') || $action == 'list')
                            <div class="tab-pane form-content-tab fade"
                                 id="{{ $tab['id']  }}"
                                 role="tabpanel" aria-labelledby="{{ $tab['id']  }}">
                                <div class="row">
                                    @foreach($tab['content'] as $key => $types)
                                        @if($key == 'inputs')
                                            @foreach($tab['content']['inputs'] as $input)
                                                @include('components.dashboard.form.inputs' , ['input' => $input])
                                            @endforeach
                                        @endif
                                        @if($key == 'includes')
                                            @foreach($tab['content']['includes'] as $include)
                                                @include($include['path'] , $include['data'])
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{ $slot }}
                </div>
            </div>
            @include('components.dashboard.tabs.footer' , ['data' => $data])
        </div>
    </div>
    @push('scripts')
        <script>
            @foreach($data['body']['tabs'] as $tab)
            @if($loop->first)
            var defaultActiveContent = $("#{{  $tab['id']}}");
            var defaultActiveTab = $("a[href$='#{{ $tab['id'] }}']")
            @endif
            @endforeach
            var errorTabFound = false;
            $('.form-content-tab').each(function (e, i) {
                var len = $(i).find('.input-error').length;
                var id = $(i).attr('id');
                if (len > 0) {
                    if (!errorTabFound) {
                        $("a[href$='#" + id + "']").addClass('active');
                        $(i).addClass('active show')
                    }
                    errorTabFound = true;
                    $('#' + id + 'HeaderTab').addClass('label label-danger btn-light-danger ml-5').html(len)
                } else {
                    @if ($errors->any())
                    $('#' + id + 'HeaderTab').addClass('label label-success btn-light-success ml-5').html('<i class="fa fa-check icon-sm text-white"></i>')
                    @endif
                }
            });
            if (!errorTabFound) {
                defaultActiveTab.addClass('active')
                defaultActiveContent.addClass('active show')
            }
        </script>
    @endpush
@endif
