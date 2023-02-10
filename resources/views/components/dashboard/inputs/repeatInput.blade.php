<div class="row rowForm{{ $input['name'] }}">
    @foreach($input['form'] as $keyForm => $valueForm)
        @php
            $valueForm['id'] = $input['name'].'-'.$keyForm;
        @endphp
        @include('components.dashboard.form.inputs' , ['input' => $valueForm])
    @endforeach
    @if($allowMulti)
        <div class="col-1">
            <div class="form-group  mt-8">
                <span onclick="removeRow{{ $input['name'] }}(this)"
                      class="btn btn-danger btn-sm add{{ $input['name'] }}"><i class="fa fa-trash"></i></span>
            </div>
        </div>
    @endif
</div>
