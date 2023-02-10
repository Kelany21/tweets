@php
    $errorName = isset($data['customErrorKey']) ? $data['customErrorKey'] :  $data['name'];
    $buttonWidth = $data['button']['width'] ?? "calc(3.5em + 3.3rem + 2px)";
    $inputID = $data['id'] ?? $data['name'];
    $buttonID = $inputID . '_button';
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
        <div
            class="{{ isset($data['icon']) ? 'input-icon' : '' }} {{ isset($data['classWrapper']) ? $data['classWrapper'] : '' }}">
            @isset($data['appendBeforeInput'])
                {!! $data['appendBeforeInput'] !!}
            @endisset
            <input type="text" name="{{ $data['name'] }}"
                   class="form-control @error($errorName) is-invalid @endif  @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
                   placeholder="@isset($data['placeHolder']) {{ $data['placeHolder'] }} @endisset"
                   id="{{ $inputID }}"
                   value="{{$data['value']}}"
                   style="padding-left: {{ $buttonWidth }}"
            @isset($data['attr'])
                @foreach ($data['attr'] as $attrName => $attr)
                    {{ $attrName }} = {{ $attr }}
                @endforeach
            @endisset
            @isset($data['required'])
                required
            @endisset
            />
            @isset($data['icon'])
                <span><i class="{{ $data['icon'] }}"></i></span>
            @endisset
                <button
                    type="button"
                    class="btn {{$data['button']['color_class'] ?? 'btn-success'}} btn-sm @isset($data['button']['class']) {{ $data['button']['class'] }} @endisset"
                    id="{{ $buttonID }}"
                    onclick="{{ $data['button']['jsFunction'] }}('{{ $inputID }}')"
                    style="width: {{ $buttonWidth }};"
                    @isset($data['button']['attr'])
                        @foreach ($data['button']['attr'] as $attrName => $attr)
                            {{ $attrName }} = {{ $attr }}
                        @endforeach
                    @endisset
                >
                    {{ $data['button']['text'] }}
                </button>
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
