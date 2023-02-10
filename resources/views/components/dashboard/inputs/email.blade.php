<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }}">
    <div class="form-group">
        @isset($data['label'])
            <label>{{ $data['label'] }}</label>
        @endisset
        <div class="{{ isset($data['icon']) ? $data['icon'] : 'input-icon' }} {{ isset($data['classWrapper']) ? $data['classWrapper'] : '' }}">
            <input type="email" name="{{ $data['name'] }}"
                   class="form-control @error($data['name']) is-invalid @endif @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
                   placeholder="@isset($data['placeHolder']) {{ $data['placeHolder'] }} @endisset"
                   id="@if(!isset($data['id'])) {{$data['name']}} @endif"
                   value="{{$data['value']}}"
            @isset($data['attr'])
                @foreach ($data['attr'] as $attrName => $attr)
                    {{ $attrName }} = {{ $attr }}
                @endforeach
            @endisset
            @isset($data['required'])
                required
            @endisset
            />
            @if(!isset($data['icon']))
                <span> <i class="flaticon-envelope text-muted"></i></span>
            @else
                <span class="{!! $data['icon'] !!} "></span>
            @endif
        </div>
        @isset($data['hint'])
            <span class="form-text text-muted">{{$data['hint']}}</span>
        @endisset
        <x-dashboard.errors.input-error name="{{ $data['name'] }}"></x-dashboard.errors.input-error>
    </div>
</div>
