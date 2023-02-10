@php
    $repeater = isset($repeater) ? $repeater : false;
    $inputIndex = 0;
    if($repeater){
        $inputIndex = $input['loopIndex'];
    }
@endphp
@if (isset($input['lang']) && $input['lang'] == true)
    @foreach (config('laravellocalization.supportedLocales') as $key => $value)
        @php
            $newversionInput = $input;
            $name =  str_replace('[]', '', $input['name']) . '_' . $key;
            $newversionInput['name'] =  str_contains($input['name'] , "[]") ? $name.'[]' :$name;
            if ($repeater) {
               $newversionInput['value'] =  RowOrOld($newversionInput['row'], $name , $inputIndex);
                $newversionInput['customErrorKey'] = $name.'.'.$inputIndex ;
            }else{
                $newversionInput['value'] =  RowOrOld($newversionInput['row'], $name);
                $newversionInput['customErrorKey'] = $name;
            }
            $newversionInput['label'] = trans('admin.' .$name );
            $newversionInput['placeHolder'] = trans('admin.' . $name. '_place_holder');
        @endphp
        @include('components.dashboard.form.swich' , ['input' => $newversionInput ])
    @endforeach
@else
         @if(isset($input['name']) && str_contains($input['name'], '[]'))
            @php
                $name  =  str_replace('[]', '', $input['name'])
            @endphp
             @if($repeater)
                @php
                    $newversionInput = $input;
                    $newversionInput['value'] =  RowOrOld($newversionInput['row'], $name , $inputIndex);
                    $newversionInput['customErrorKey'] = $name.'.'.$inputIndex ;
                    $newversionInput['label'] = trans('admin.' .$name);
                    $newversionInput['placeHolder'] = trans('admin.' . $name. '_place_holder');
                @endphp
                @include('components.dashboard.form.swich' , ['input' => $newversionInput ])
            @else
                @php
                if (isset($input['row'])) {
                    $input['value'] =  RowOrOld($input['row'], $name);
                }
                @endphp
                @include('components.dashboard.form.swich' , ['input' => $input ])
            @endif
         @else
            @include('components.dashboard.form.swich' , ['input' => $input ])
        @endif


@endif
