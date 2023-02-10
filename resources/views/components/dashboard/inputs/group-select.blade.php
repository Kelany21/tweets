@php
    $labelKey = isset($data['labelKey']) ? $data['labelKey'] : 'label';
    $valueKey = isset($data['valueKey']) ? $data['valueKey'] : 'value';
    $group_by = isset($data['group_by']) ? $data['group_by'] : 'name';
    $optionsKey = isset($data['optionsKey']) ? $data['optionsKey'] : 'relation';
      $errorName = isset($data['customErrorKey']) ? $data['customErrorKey'] :  $data['name'];
@endphp
<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }}">
    <div class="form-group">
        @isset($data['label'])
            <label>{{ $data['label'] }}</label>
        @endisset
        <div class="{{ isset($data['icon']) ? 'input-icon' : '' }}">
            <select type="text" name="{{ $data['name'] }}"
                    class="form-control @error($errorName) is-invalid @endif  @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
                    placeholder="@isset($data['placeHolder']) {{ $data['placeHolder'] }} @endisset"
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
            @foreach($data['options'] as $groupIndex => $groupOption)
{{--                {{ dd($groupOption) }}--}}
                <optgroup label="{{ $groupOption[$group_by] }}">
                    @foreach($groupOption->$optionsKey as $index => $option)
                        @php $index = $option[$valueKey] ?? $index @endphp
                        @php $option = $option[$labelKey] ?? $option @endphp
                        <option
                            value="{{ $index }}"
                            {{ $data['value'] == $index ? 'selected' : (isset($option['selected']) ? 'selected' : '') }}
                            {{ isset($option['disabled']) ? 'disabled' : '' }}
                            {{ isset($option['deleted_at']) &&  $option['deleted_at'] != '' ? 'disabled' : '' }}
                        >{{ $option }}</option>
                    @endforeach
                </optgroup>
                @endforeach
                </select>
                @isset($data['icon'])
                    <span><i class="{{ $data['icon'] }}"></i></span>
                @endisset
        </div>
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
