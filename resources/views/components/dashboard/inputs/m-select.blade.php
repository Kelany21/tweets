@php
    $labelKey = isset($data['labelKey']) ? $data['labelKey'] : 'label';
    $valueKey = isset($data['valueKey']) ? $data['valueKey'] : 'value';
    $errorName = isset($data['customErrorKey']) ? $data['customErrorKey'] :  $data['name'];
@endphp

@push('style')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush

<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }}">
    <div class="form-group">
        @isset($data['label'])
            <label>{{ $data['label'] }}</label>
        @endisset
        <select multiple type="text" name="{{ $data['name'] }}"
                class="form-control  selectpicker @error($errorName) is-invalid @endif  @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
                placeholder="@isset($data['placeHolder']) {{ $data['placeHolder'] }} @endisset"
                id="@if(!isset($data['id'])){{$data['name']}}@endif"
        @isset($data['attr']) @foreach ($data['attr'] as $attrName => $attr) {{ $attrName }}
        = {{ $attr }} @endforeach @endisset
        @isset($data['required']) required @endisset>
        @foreach ($data['options'] as $index => $option)
            @php $index = $option[$valueKey] ?? $index @endphp
            @php $option = $option[$labelKey] ?? $option @endphp
            <option value="{{ $index }}"
                {{ in_array($index, $data['value']) ? 'selected' : (isset($option['selected']) ? 'selected' : '') }}
                {{ isset($option['disabled']) ? 'disabled' : '' }}
                {{ isset($option['deleted_at']) && $option['deleted_at'] != '' ? 'disabled' : '' }}>
                {{ $option }}</option>
            @endforeach
            </select>
            @isset($data['hint'])
                <span class="form-text text-muted">{{ $data['hint'] }}</span>
            @endisset
            <x-dashboard.errors.input-error name="{{ $errorName }}"></x-dashboard.errors.input-error>
    </div>
</div>
@push('scripts')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        @isset($data['pushScript'])
            {!! $data['pushScript'] !!}
        @endisset
    </script>
@endpush
