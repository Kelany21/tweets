<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }}">
    <div class="form-group">
        @isset($data['label'])
            <label>{{ $data['label'] }}</label>
        @endisset
        <div class="input-daterange input-group" id="kt_datepicker">
            <input type="text" class="form-control @error($data['name']['start']) is-invalid @endif datatable-input" name="{{ $data['name']['start'] }}"
                   placeholder="@isset($data['placeHolder']['start']) {{ $data['placeHolder']['start'] }} @endisset"
                   id="{{$data['name']['start']}}"
                   value="{{$data['value']['start']}}"
            @foreach ($data['attr'][0] as $attrName => $attr)
                {{ $attrName }} = {{ $attr }}
            @endforeach
            />
            <div class="input-group-append">
                <span class="input-group-text"><i class="flaticon2-calendar-6"></i></span>
            </div>
            <input type="text" class="form-control @error($data['name']['end']) is-invalid @endif datatable-input" name="{{ $data['name']['end'] }}"
                   placeholder="@isset($data['placeHolder']['end']) {{ $data['placeHolder']['end'] }} @endisset"
                   id="{{$data['name']['end']}}"
                   value="{{$data['value']['end']}}"
            @foreach ($data['attr'][1] as $attrName => $attr)
                {{ $attrName }} = {{ $attr }}
            @endforeach
            />
        </div>
    </div>
    @isset($data['hint'])
        <span class="form-text text-muted">{{$data['hint']}}</span>
    @endisset
    <x-dashboard.errors.input-error name="{{ $data['name']['start'] }}"></x-dashboard.errors.input-error>
    <x-dashboard.errors.input-error name="{{ $data['name']['end'] }}"></x-dashboard.errors.input-error>
</div>

