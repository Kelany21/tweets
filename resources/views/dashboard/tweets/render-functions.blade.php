<script>
    function trans(key){
        return @json(trans("admin"))[key] ?? 'admin.' + key
    }

    function author(data, type, full, meta) {
        data = JSON.parse(data)
        var html = '';
        html += '<div class="d-flex align-items-center">'
        html += '<div class="symbol symbol-40 symbol-light-warning flex-shrink-0">	'
        if (data.picture) {
            html += '<img class="" src="' + data.picture + '" alt="photo">';
        } else {
            html += '<span class="symbol-label font-size-h4 font-weight-bold">' + data.name.charAt(0) + '</span>';
        }
        html += ' </div>';
        html += ' <div class="ml-4">';
        html += ' <div class="font-weight-bolder text-black-50 font-size-lg mb-0">' + data.name + '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    }

    function text(data, type, full, meta) {
        const modalContent = '<span>' + data + '</span>'
        const ModalTitle = '{{ trans("admin.text") }}';
        const ModalID = 'text_' + full.id;
        const dataSubstring = data.substring(0, 50)
        return '<span style="width: 100%;display: inline-table;">' +
            dataSubstring +
            (dataSubstring !== data ?
                '... <a style="font-weight: bold" class="btn" data-toggle="modal" data-target="#' + ModalID + '">' + trans('read_more') + '</a>'
                : '') +
            '</span>' +
            '<div class="modal fade" id="' + ModalID + '" data-backdrop="static" tabindex="-1" role="dialog"' +
            'aria-labelledby="staticBackdrop" aria-hidden="true">' +
            '<div class="modal-dialog modal-dialog-centered" role="document">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<h5 class="modal-title" id="' + ModalID + '_label">' + ModalTitle + '</h5>' +
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
            '<i aria-hidden="true" class="ki ki-close"></i>' +
            '</button>' +
            '</div>' +
            '<div class="modal-body">' + modalContent + '</div>' +
            '</div' +
            '</div>' +
            '</div>';
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

    function seenUsers(data, type, full, meta) {
        data = JSON.parse(data);
        let modalContent
        if (data.length) {
            modalContent = '<div class="row">'
            for (const seenUser of data) {
                modalContent += '<div class="d-flex align-items-center col-md-12">'
                modalContent += '<div class="symbol symbol-40 symbol-light-warning flex-shrink-0">	'
                if (seenUser.picture) {
                    modalContent += '<img class="" src="' + seenUser.picture + '" alt="photo">';
                } else {
                    modalContent += '<span class="symbol-label font-size-h4 font-weight-bold">' + seenUser.name.charAt(0) + '</span>';
                }
                modalContent += ' </div>';
                modalContent += ' <div class="ml-4">';
                modalContent += ' <div class="font-weight-bolder text-black-50 font-size-lg mb-0">' + seenUser.name + '</div>';
                modalContent += '</div>';
                modalContent += '</div>';
            }
            modalContent += '</div>'
        } else {
            modalContent = '<span>' + trans('no_sees') + '</span>'
        }
        const ModalTitle = '{{ trans("admin.seenUsers") }}';
        const ModalID = 'seenUsers_' + full.id;
        return '<span style="text-align: center !important;width: 100%;display: inline-table;">' +
            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' + ModalID + '">' +
            '<i class="fa fas fa-eye"></i>' +
            '</button>' +
            '</span>' +
            '<div class="modal fade" id="' + ModalID + '" data-backdrop="static" tabindex="-1" role="dialog"' +
            'aria-labelledby="staticBackdrop" aria-hidden="true">' +
            '<div class="modal-dialog modal-dialog-centered" role="document">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<h5 class="modal-title" id="' + ModalID + '_label">' + ModalTitle + '</h5>' +
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
            '<i aria-hidden="true" class="ki ki-close"></i>' +
            '</button>' +
            '</div>' +
            '<div class="modal-body">' + modalContent + '</div>' +
            '</div' +
            '</div>' +
            '</div>';
    }
</script>
