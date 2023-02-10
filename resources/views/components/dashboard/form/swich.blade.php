@switch($input['type'])
@case('label')
@include('components.dashboard.inputs.label' , ['data' => $input  ])
@break
@case('date')
@include('components.dashboard.inputs.date' , ['data' => $input  ])
@break
@case('repeater')
@include('components.dashboard.inputs.repeater' , ['data' => $input  ])
@break
@case('text')
@include('components.dashboard.inputs.text' , ['data' => $input  ])
@break
@case('text-with-button')
@include('components.dashboard.inputs.text-with-button' , ['data' => $input  ])
@break
@case('number')
@include('components.dashboard.inputs.number' , ['data' => $input ])
@break
@case('image')
@include('components.dashboard.inputs.image' , ['data' => $input ])
@break
@case('submit-button')
@include('components.dashboard.inputs.submit-button' , ['data' => $input ])
@break
@case('email')
@include('components.dashboard.inputs.email' , ['data' => $input ])
@break
@case('password')
@include('components.dashboard.inputs.password' , ['data' => $input])
@break
@case('select')
@include('components.dashboard.inputs.select' , ['data' => $input ])
@break
@case('custom-select')
@include('components.dashboard.inputs.custom-select' , ['data' => $input ])
@break
@case('group-select')
@include('components.dashboard.inputs.group-select' , ['data' => $input ])
@break
@case('m-select')
@include('components.dashboard.inputs.m-select' , ['data' => $input])
@break
@case('radio')
@include('components.dashboard.inputs.radio' , ['data' => $input])
@break
@case('textarea')
@include('components.dashboard.inputs.textarea' , ['data' => $input ])
@break
@case('checkboxs')
@include('components.dashboard.inputs.checkboxs' , ['data' => $input ])
@break
@case('url')
@include('components.dashboard.inputs.url' , ['data' => $input ])
@break
@case('checkbox')
@include('components.dashboard.inputs.checkbox' , ['data' => $input ])
@break
@case('repeater-checkbox')
@include('components.dashboard.inputs.repeater-checkbox' , ['data' => $input ])
@break
@case('date-range')
@include('components.dashboard.inputs.date-range' , ['data' => $input])
@break
@default
@break
@endswitch
