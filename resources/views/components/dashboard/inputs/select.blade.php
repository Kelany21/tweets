@php
    $labelKey = isset($data['labelKey']) ? $data['labelKey'] : 'label';
    $valueKey = isset($data['valueKey']) ? $data['valueKey'] : 'value';
      $errorName = isset($data['customErrorKey']) ? $data['customErrorKey'] :  $data['name'];
@endphp
<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }}">
    <div class="form-group">
        @isset($data['label'])
            <label>{{ $data['label'] }}</label>
        @endisset

        <div
            class="{{ isset($data['icon']) ? 'input-icon' : '' }} {{ isset($data['classWrapper']) ? $data['classWrapper'] : '' }}">
            <select name="{{ $data['name'] }}"
                    class="form-control @error($errorName) is-invalid @endif  @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
                    placeholder="@isset($data['placeHolder']) {{ $data['placeHolder'] }} @endisset"
                    id="@if(!isset($data['id'])){{$data['name']}}@endif"
            @isset($data['attr'])
                @foreach ($data['attr'] as $attrName => $attr)
                    {{ $attrName }} = {{ $attr }}
                @endforeach
            @endisset
            @isset($data['required'])
                required
            @endisset
            @isset($data['onchange'])
                onchange="{{ $data['onchange'] }}"
            @endisset
            >
            @foreach($data['options'] as $index => $option)
                @php $index = $option[$valueKey] ?? $index @endphp
                @php $option = !is_array($labelKey) && isset($option[$labelKey]) ? $option[$labelKey] :  $option @endphp
                <option
                    value="{{ $index }}"
                    {{ $data['value'] == $index ? 'selected' : (isset($option['selected']) ? 'selected' : '') }}
                    {{ isset($option['disabled']) ? 'disabled' : '' }}
                    {{ isset($option['deleted_at']) &&  $option['deleted_at'] != '' ? 'disabled' : '' }}
                >
                    @if(is_array($labelKey))
                        @php $op = $data['transKeys'] @endphp
                        @if(isset($option['transKeys']))
                            @php $op = $option['transKeys'] @endphp
                        @else
                            @php $op = $data['transKeys'] @endphp
                        @endif
                        @foreach($labelKey as $label)
                            @if(!$loop->first)
                                -
                            @endif
                            @if(key_exists($label , $op) && isset($op[$label]['where']) && $op[$label]['where'] == 'before')
                                {{ $op[$label]['trans'] }}
                            @endif
                            {{ $option->{$label} ?? '' }}
                            @if(key_exists($label , $op) && isset($op[$label]['where']) && $op[$label]['where'] == 'after')
                                {{ $op[$label]['trans'] }}
                            @endif
                        @endforeach
                    @else
                        {{ $option }}
                    @endif

                </option>
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
