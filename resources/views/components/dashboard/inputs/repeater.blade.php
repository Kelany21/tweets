@php
    $formArray = isset($input['form']) ? $input['form'] : [];
    $values = isset($input['values']) ?  $input['values'] : [];
    $allowMulti = isset($input['multi']) ? $input['multi'] : false;
@endphp
<div class="col-12">
    <div id="reaptForm{{ $input['name'] }}">
        @if($input['action'] == 'edit' && !old())
            @foreach($values as $oldInput)
                <div class="row rowForm{{ $input['name'] }}">
                    <input type="hidden" name="{{ $input['idsColumn'] }}[]" value="{{  $oldInput->id }}">
                    @foreach($input['form'] as $keyForm => $valueForm)
                        @php
                            $valueForm['id'] = $input['name'].'-'.$keyForm;
                            $valueForm['row'] = $oldInput;
                        @endphp
                        @include('components.dashboard.form.inputs' , ['input' => $valueForm])
                    @endforeach
                    @if($allowMulti)
                        <div class="col-1">
                            <div class="form-group mt-8">
                            <span onclick="removeRow{{ $input['name'] }}(this)"
                                  class="btn btn-danger btn-sm add{{ $input['name'] }}"><i
                                    class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
        @if(!empty(old($input['loopColumn'])))
            @foreach(old($input['loopColumn']) as  $keyo => $column )
                <div class="row rowForm{{ $input['name'] }}">
                    @if(old('ids') && isset(old('ids')[$keyo]))
                        <input type="hidden" name="ids[]" value="{{  old('ids')[$keyo] }}">
                    @endif
                    @foreach($input['oldData'] as $old)
                        @php
                            $oldDataValue = $formArray[$old['columnName']];
                            $oldDataValue['id'] = $old['columnName'].'-'.$old['columnName'];
                            $oldDataValue['loopIndex'] = $keyo;
                            $oldDataValue['lang'] = $old['lang'] ?? false;
                        @endphp
                        @include('components.dashboard.form.inputs' , ['input' => $oldDataValue , 'repeater'=> true ])
                    @endforeach
                    @if($allowMulti)
                        <div class="col-1">
                            <div class="form-group mt-8">
                            <span onclick="removeRow{{ $input['name'] }}(this)"
                                  class="btn btn-danger btn-sm add{{ $input['name'] }}"><i
                                    class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
        @if($input['action'] == 'create' && !old())
            @include('components/dashboard/inputs/repeatInput' , ['allowMulti' => $allowMulti])
        @elseif(!$allowMulti && $input['action'] == 'edit'&& !old() && $values->isEmpty())
            @include('components/dashboard/inputs/repeatInput' , ['allowMulti' => $allowMulti])
        @endif
    </div>
</div>
@if($allowMulti)
    <div class="col-12">
        <span onclick="addNewRow{{ $input['name'] }}()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></span>
        <span onclick="removeAllRow{{ $input['name'] }}()" class="btn btn-danger btn-sm add{{ $input['name'] }}"><i
                class="fa fa-trash"></i></span>
    </div>
@endif
@push('scripts')
    <script type="text/javascript">
        var row{{ $input['name'] }} = null, defaultRow{{ $input['name'] }} = null,
            add{{ $input['name'] }} = $('.add{{ $input['name'] }}');

        function addNewRow{{ $input['name'] }}() {
            var id = makeid(5);
            defaultRow{{ $input['name'] }} = `@include('components/dashboard/inputs/repeatInput')`;
            defaultRow{{ $input['name'] }}  = defaultRow{{ $input['name'] }}.replace(/id=\"[a-z0-9A-Z]+\"/gm, 'id="' + id + '"');
            $('#reaptForm{{ $input['name'] }}').append(defaultRow{{ $input['name'] }});
        }

        function removeRow{{ $input['name'] }}(e) {
            $(e).closest('div.rowForm{{ $input['name'] }}').remove();
        }

        function removeAllRow{{ $input['name'] }}() {
            defaultRow{{ $input['name'] }} = `@include('components/dashboard/inputs/repeatInput')`;
            $('#reaptForm{{ $input['name'] }}').html(defaultRow{{ $input['name'] }});
        }

        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }


    </script>
@endpush
