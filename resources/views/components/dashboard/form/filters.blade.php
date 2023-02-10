@if (isset($input['lang']) && $input['lang'] == true)
    @foreach (config('laravellocalization.supportedLocales') as $key => $value)
        @php
            $newversionInput = $input;
            $name =  str_replace('[]', '', $input['name']) . '_' . $key;
            $newversionInput['name'] =  str_contains($input['name'] , "[]") ? $name.'[]' :$name;
            $newversionInput['value'] =  RowOrOld($newversionInput['row'], $name);
            $newversionInput['customErrorKey'] = $name;
            $newversionInput['label'] = trans('admin.' .$name );
            $newversionInput['placeHolder'] = trans('admin.' . $name. '_place_holder');
        @endphp
        @include('components.dashboard.form.swich' , ['input' => $newversionInput ])
    @endforeach
@else
    @include('components.dashboard.form.swich' , ['input' => $input ])
@endif
