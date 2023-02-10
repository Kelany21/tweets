@php
    $options = $data['options']->groupBy($data['groupBy']);
@endphp

@foreach($options as $key => $option)
    <div class="pb-4 {{ $loop->first ?:'pt-4' }} {{ $loop->last ?: 'border-bottom-lg'}}">
        @php $data['label'] = trans('admin.'.$key) @endphp
        @php $data['options'] = $option @endphp
        @include('components.dashboard.inputs.checkbox' , ['data' => $data])
    </div>
@endforeach



