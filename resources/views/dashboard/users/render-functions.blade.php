<script>
    function trans(key){
        const adminTrans = @json(trans("admin"));
        return adminTrans[key] ?? 'admin.' + key
    }

    function group_id(data, type, full, meta) {
        @if(in_array('toggle' , $modulePermissions))
        if (!full.deleted_at) {
            var select = '<select class="form-control select" onchange="changeRole(' + full.id + ')" id="roll_' + full.id + '">';
            @foreach($allGroups as $group)
                select += '<option value="{{ $group['id'] }}" ';
            select += '{{  $group['id'] }}' === data ? 'selected' : '';
            select += '{{  isset($group['deleted_at']) && $group['deleted_at'] != '' ? 'disabled' : '' }}';
            select += '>{{ $group['name'] }}</option>';
            @endforeach
                select += '</select>';

            return select;
        } else {
            return returnGroupIdDivOnly(data);
        }
        @else
            return returnGroupIdDivOnly(data);
        @endif
    }

    function returnGroupIdDivOnly(data) {
        return '<span class="label label-inline label-light-primary font-weight-bold">' + data + '</span>';
    }

    function changeRole(id) {
        window.location = '{{ uA($moduleRoute.'/toggle/') }}/' + id + '/group_id/' + $('#roll_' + id).val()
    }

    function name(data, type, full, meta) {
        var html = '';
        html += '<div class="d-flex align-items-center">'
        html += '<div class="symbol symbol-40 symbol-light-warning flex-shrink-0">	'
        if (full.picture) {
            html += '<img class="" src="' + full.picture + '" alt="photo">';
        } else {
            html += '<span class="symbol-label font-size-h4 font-weight-bold">' + data.charAt(0) + '</span>';
        }
        html += ' </div>';
        html += ' <div class="ml-4">';
        @if($allowEdit)
        if(!full.deleted_at){
            html += ' <div class="font-weight-bolder text-black-50 font-size-lg mb-0"><a href="{{ uA($moduleRoute) }}/' + full.id + '/edit" class="text-black-50 text-hover-warning"> ' + data + '</a></div>';
        }else{
            html += ' <div class="font-weight-bolder text-black-50 font-size-lg mb-0">' + data + '</div>';
        }
        @else
            html += ' <div class="font-weight-bolder text-black-50 font-size-lg mb-0">' + data + '</div>';
        @endif
            html += ' <div class="text-dark-75 font-weight-light  mb-0">' + dateRender(full.updated_at, 'withTime') + '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    }

    function toggle(id){
        $.get("{{ uA($moduleRoute) }}" + "/" + id + "/status-toggle");
    }
    function status(data, type, full, meta) {
        @if(in_array('toggle' , $modulePermissions))
        const checked = data === 'active' ? 'checked="checked"' : ''
        return '<span class="switch switch-icon" style="text-align: center !important;width: 100%;display: inline-table;"> ' +
            '<label> <input type="checkbox" ' + checked + ' name="select" onclick="toggle(' + full.id + ')"/> <span></span> </label>' +
            '</span>';
        @endif
        const icon = data === 'active' ? '<i class="far fa-check-square icon-2x text-success mr-5"></i>' : '<i class="flaticon-cancel icon-2x text-danger"></i>'
        return '<span style="text-align: center !important;width: 100%;display: inline-table;">' + icon + '</span>'
    }
</script>
