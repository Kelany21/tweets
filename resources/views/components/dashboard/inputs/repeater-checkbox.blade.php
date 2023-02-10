@php
    $labelKey = isset($data['labelKey']) ? $data['labelKey'] : 'label';
    $valueKey = isset($data['valueKey']) ? $data['valueKey'] : 'value';
@endphp

<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }}">
    <div class="form-group mb-0">
        @isset($data['label'])
            <label>{{ $data['label'] }}</label>
        @endisset
        <div class="checkbox-inline mt-3">
            @foreach($data['options'] as $option)
                <label class="checkbox">
                    <input type="checkbox" value="{{$option[$valueKey]}}"
                           {{ $option[$valueKey] == $input['value'] ? 'checked=checked'  :'' }} 
                           name="{{ $data['name'] }}"
                           class=" @error($data['name']) is-invalid @endif @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
                   id="@if(!isset($data['id'])) {{$data['name']}} @endif"
                    @isset($data['attr'])
                        @foreach ($data['attr'] as $attrName => $attr)
                            {{ $attrName }} = {{ $attr }}
                        @endforeach
                    @endisset
                    @isset($data['required'])
                        required
                    @endisset
                    >
                    <span></span>
                    {{ $option[$labelKey] }}
                </label>
            @endforeach
        </div>
            @isset($data['hint'])
                <span class="form-text text-muted">{{$data['hint']}}</span>
            @endisset
            <x-dashboard.errors.input-error name="{{ $data['name'] }}"></x-dashboard.errors.input-error>
    </div>
</div>

