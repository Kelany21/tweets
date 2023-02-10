<div class="{{ isset($data['class']) ? $data['class'] : 'col-md-4 my-2 my-md-0' }} textInput">
    <div class="form-group">
        <div class="{{ isset($data['icon']) ? 'input-icon' : '' }} {{ isset($data['classWrapper']) ? $data['classWrapper'] : '' }}">
            @isset($data['appendBeforeInput'])
                {!! $data['appendBeforeInput'] !!}
            @endisset
                <button class="btn btn-warning font-weight-bolder btn-sm @isset($data['inputClass']) {{ $data['inputClass'] }} @endisset"
                @isset($data['id'])
                id="{{ $data['id'] }}"
                @endisset
                @isset($data['attr'])
                    @foreach ($data['attr'] as $attrName => $attr)
                        {{ $attrName }} = {{ $attr }}
                    @endforeach
                @endisset
                >
                    {{ $data['label'] }}
                </button>
            @isset($data['icon'])
                <span><i class="{{ $data['icon'] }}"></i></span>
            @endisset
        </div>
        @isset($data['appendAfterInput'])
            {!! $data['appendAfterInput'] !!}
        @endisset
    </div>
</div>

@isset($data['pushScript'])
    @push('scripts')
        <script>
            {!! $data['pushScript'] !!}
        </script>
    @endpush
@endisset
