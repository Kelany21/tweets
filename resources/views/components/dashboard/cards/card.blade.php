@php
    $allowInEdit = isset($data['showOnEdit']) ? $data['showOnEdit']: true;
    $allowInCreate= isset($data['showOnCreate']) ? $data['showOnCreate'] : true;
@endphp
@if(($allowInEdit && $action == 'edit') || ($allowInCreate && $action == 'create') || $action == 'list')
    <div class="@isset($data['class']) {{ $data['class'] }}@endisset"
         id="@isset($data['id']) {{ $data['id'] }}@endisset ">
        <div class="card card-custom @isset($data['sticky']) sticky @endisset"
             @isset($data['sticky']) data-sticky="true" data-margin-top="140px" data-sticky-for="1023"
             data-sticky-class="sticky"@endisset>
            @isset($data['header'])
                <div class="card-header  @isset($data['header']['class']) {{ $data['header']['class'] }}@endisset"
                     id="@isset($data['header']['id']) {{ $data['header']['id'] }}@endisset">
                    @isset($data['header']['title'])
                        <div class="card-title">
                            @isset($data['header']['icon'])
                                <span class="card-icon">
                             <i class="{{ $data['header']['icon'] }}"></i>
                        </span>
                            @endisset
                            <h3 class="card-label">
                                {!! $data['header']['title'] !!}
                            </h3>
                        </div>
                    @endisset

                    @isset($data['header']['left'])
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-sm btn-success font-weight-bold">
                                <i class="flaticon2-cube"></i> Reports
                            </a>
                        </div>
                    @endisset
                </div>
            @endisset
            <div class="card-body @isset($data['body']['class']) {{ $data['body']['class'] }}@endisset"
                 id="@isset($data['body']['id']) {{ $data['body']['id'] }}@endisset">
                <div class="row">
                    @foreach($data['body'] as $key => $types)
                        @if($key == 'inputs')
                            @foreach($data['body']['inputs'] as $input)
                                @include('components.dashboard.form.inputs' , ['input' => $input ])
                            @endforeach
                        @endif
                        @if($key == 'includes')
                            @foreach($data['body']['includes'] as $include)
                                @include($include['path'] , $include['data'])
                            @endforeach
                        @endif
                    @endforeach
                    {{ $slot }}
                </div>
            </div>
            @isset($data['footer'])
                <div class="card-footer d-flex justify-content-between">
                    <a href="#" class="btn btn-light-primary font-weight-bold">Manage</a>
                    <a href="#" class="btn btn-outline-secondary font-weight-bold">Learn more</a>
                </div>
            @endisset
        </div>
    </div>
@endif
