<script>
    function name(data, type, full, meta) {
        var html = '';
        html += '<div class="d-flex align-items-center">'
        html += '<div class="symbol symbol-40 symbol-light-warning flex-shrink-0">	'
        if (full.image) {
            html += '<img class="" src="' + full.image + '" alt="photo">';
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
</script>
