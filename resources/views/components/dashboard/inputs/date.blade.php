<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }}">
    <div class="form-group">
        @isset($data['label'])
            <label>{{ $data['label'] }}</label>
        @endisset
        <div class="date input-group {{ isset($data['icon']) ? 'input-icon' : '' }} {{ isset($data['classWrapper']) ? $data['classWrapper'] : '' }}">
            <input type="date" class="form-control @error($data['name']) is-invalid @endif datatable-input" name="{{ $data['name'] }}"
                   placeholder="@isset($data['placeHolder']) {{ $data['placeHolder'] }} @endisset"
                   id="{{$data['name']}}"
                   value="{{ $data['value'] ? $data['value']->format("Y-m-d") : '' }}"
            @isset($data['attr'])
                @foreach ($data['attr'] as $attrName => $attr)
                    {{ $attrName }} = {{ $attr }}
                @endforeach
            @endisset
            />
            @isset($data['icon'])
                <span><i class="{{ $data['icon'] }}"></i></span>
            @endisset
        </div>
    </div>
    @isset($data['hint'])
        <span class="form-text text-muted">{{$data['hint']}}</span>
    @endisset
    <x-dashboard.errors.input-error name="{{ $data['name'] }}"></x-dashboard.errors.input-error>
</div>



