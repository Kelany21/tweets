@php
  $errorName = isset($data['customErrorKey']) ? $data['customErrorKey'] :  $data['name'];
@endphp
<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }} textInput">
    <div class="form-group">
        @isset($data['label'])
            @isset($data['appendBeforeLabel'])
                {!! $data['appendBeforeLabel'] !!}
            @endisset
            <label>{{ $data['label'] }}</label>
            @isset($data['appendAfterLabel'])
                {!! $data['appendAfterLabel'] !!}
            @endisset
        @endisset
        <div class="{{ isset($data['icon']) ? 'input-icon' : '' }}">
            @isset($data['appendBeforeInput'])
                {!! $data['appendBeforeInput'] !!}
            @endisset
            <input type="number" name="{{ $data['name'] }}"
                   class="form-control @error($errorName) is-invalid @endif  @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
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
            @isset($data['max'])
                max="{{ $data['max'] }}"
            @endisset
            @isset($data['min'])
                    min="{{ $data['min'] }}"
            @endisset
            />
            @isset($data['icon'])
                <span><i class="{{ $data['icon'] }}"></i></span>
            @endisset
        </div>
        @isset($data['appendAfterInput'])
            {!! $data['appendAfterInput'] !!}
        @endisset
        @isset($data['hint'])
            <span class="form-text text-muted">{{$data['hint']}}</span>
        @endisset
        <x-dashboard.errors.input-error name="{{ $errorName }}"></x-dashboard.errors.input-error>
    </div>
</div>

@isset($data['pushScript'])
    @push('scripts')
        <script>
            {!! $data['pushScript'] !!}
        </script>
    @endpush
@endisset
