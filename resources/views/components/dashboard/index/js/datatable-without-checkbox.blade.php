<script type="text/javascript">
    let columns = [];
    let startColumns = {
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false,
        searchable: false,
        width: 20,
    };

    function deleteTableRow(e, id) {
        e.preventDefault;
        Swal.fire({
            title: "{{trans('admin.are_you_sure_delete_row')}}",
            text: "{{ trans('admin.You_wont_be_able_to_revert_this!') }}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{ trans('admin.Yes,_delete_it!') }}"
        }).then(function (result) {
            if (result.value) {
                window.location = $(e).data('url')
            }
        });
    }

    function checkedInput(e) {
        var count = 0;
        $('.checkable').each(function (item, index) {
            if ($(index).prop('checked') === true) {
                count++;
            }
        })
        $('.selectedLength').html(count)
    }

    // columns.push(startColumns);
    let backEndColumns = [];
    @foreach($table as $column)
        backEndColumns = {!! json_encode($column) !!};
    @isset($column['render'])
        backEndColumns['render'] = {!! $column['render'] !!} ;
    @endisset
    columns.push(backEndColumns);
        @endforeach
    let endColumns = {
            data: 'created_at',
            name: 'created_at',
            responsivePriority: -2
        };
    columns.push(endColumns);
    endColumns = {
        data: 'Actions',
        name: 'actions',
        responsivePriority: -1
    };
    columns.push(endColumns);

    var KTDatatablesSearchOptionsAdvancedSearch = function () {

        $.fn.dataTable.Api.register('column().title()', function () {
            return $(this.header()).text().trim();
        });
        var initTable1 = function () {
            var table = $('#kt_datatable').DataTable({
                // fixedHeader: true,
                // stateSave: true,
                "search": {
                    "caseInsensitive": false
                },
                select: {
                    style: 'multi',
                    selector: 'td:first-child .checkable',
                    orderable : false,
                },
                headerCallback: function (thead, data, start, end, display) {
                    var checkCount = $('.checkable').length;
                    var styleCheckBox = 'display:none;'
                    if(checkCount > 0){
                        styleCheckBox = 'display:block;'
                    }
                    // thead.getElementsByTagName('th')[0].innerHTML = `
                    // <label class="checkbox checkbox-single checkbox-solid checkbox-primary mb-0" >
                    //     <input type="checkbox"  class="group-checkable" style="`+styleCheckBox+`"/>
                    //     <span></span>
                    // </label>`;
                },
                responsive: true,
                processing: true,
                serverSide: true,
                dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                searchDelay: 500,
                ajax: "{{ uA($data.'/get-rows?delete='.request()->get('delete')) }}",
                method: "GET",
                drawCallback: function (setting) {
                    $('.count').addClass('label label-success btn-light-success').html(setting._iRecordsDisplay)
                    $('.show').html(setting._iRecordsDisplay)
                    $('.all').html(setting._iRecordsTotal)
                },
                columns: columns,
                columnDefs: [
                    // {
                    //     targets: 0,
                    //     orderable: false,
                    //     render: function (data, type, full, meta) {
                    //         var allow = {{ json_encode($notAllowToDelete) }};
                    //         var out = `
                    //             <label class="checkbox checkbox-single checkbox-primary mb-0" >
                    //                 <input type="checkbox" name="ids[]" value="` + full.id + `" onclick="checkedInput(this)" class="checkable"/>
                    //                 <span></span>
                    //             </label>`;
                    //         if (!allow.includes(full.id)) {
                    //             return out;
                    //         }

                    //         return '';

                    //     },
                    // },
                    {
                        targets: -2,
                        title: '{{ trans('admin.created_at') }}',
                        orderable: true,
                        searchable: false,
                        name: 'created_at',
                        width: 80,
                        render: function (data, type, full, meta) {
                            return dateRender(data);
                        },
                    },
                    {
                        targets: -1,
                        name: 'actions',
                        title: '{{ trans('admin.action') }}',
                        orderable: false,
                        searchable: false,
                        width: 80,
                        render: function (data, type, full, meta) {
                            var out = "";
                            var allow = {{ json_encode($notAllowToDelete) }};
                            if (!full.deleted_at) {
                                var editUrl = @if(isset($editUrl)) '{{ $editUrl }}' + data
                                @else '{{ uA($data) }}/' + data + '/edit' @endif;
                                var deleteUrl = @if(isset($deleteUrl)) '{{ $deleteUrl }}' + data
                                @else '{{ uA($data) }}/' + data + '/delete' @endif;
                                @if($allowEdit)
                                    out += `<a href="` + editUrl + `" class="btn btn-light-success btn-xs btn-clean btn-icon mr-2 ml-2" data-toggle="tooltip" data-theme="dark" title="{{ trans('admin.edit') }}"><i class="la la-edit"></i></a>`;
                                @endif
                                @if($allowDelete)
                                    if (!allow.includes(data)) {
                                        out += `<a href="#" data-url="` + deleteUrl + `" class="btn btn-light-danger btn-xs btn-clean btn-icon " onclick="deleteTableRow(this , ` + data + `)" data-toggle="tooltip" data-theme="dark" title="{{ trans('admin.delete') }}"><i class="la la-trash"></i></a>`;
                                    }
                                @endif
                            } else {
                                var restoreUrl = @if(isset($restoreUrl)) '{{ $restoreUrl }}' + data
                                @else '{{ uA($data) }}/' + data + '/restore' @endif;
                                var deletePermanentlyUrl = @if(isset($restoreUrl)) '{{ $restoreUrl }}' + data
                                @else '{{ uA($data) }}/' + data + '/delete-permanently' @endif;
                                out += '<div class="text-center">';
                                @if(in_array('restore' , $modulePermissions))
                                     out += `<a href="` + restoreUrl + `"  class="btn btn-light-warning btn-xs btn-clean btn-icon mr-2" data-toggle="tooltip" data-theme="dark" title="{{ trans('admin.restore') }}"><i class="flaticon-refresh"></i></a>`;
                                @endif
                                @if($allowDelete)
                                    if (!allow.includes(data)) {
                                        out += `<a href="#" data-url="` + deletePermanentlyUrl + `"  class="btn btn-light-danger btn-xs btn-clean btn-icon" data-toggle="tooltip" onclick="deleteTableRow(this , ` + data + `)" data-theme="dark" title="{{ trans('admin.deletePermanently') }}"><i class="la la-trash"></i></a>`;
                                    }
                                @endif
                                out += `</div>`;
                            }

                            return out;
                        },
                    }
                ]
            });

            table.CaseSensitive = false ;


            var filter = function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
            };

            var asdasd = function (value, index) {
                var val = $.fn.dataTable.util.escapeRegex(value);
                table.column(index).search(val ? val : '', false, true);
            };

            $('#kt_search').on('click', function (e) {
                e.preventDefault();
                $('.selectedLength').html(0)
                var params = {};
                $('.datatable-input').each(function () {
                    var i = $(this).data('col-index');
                    if (params[i] && $(this).attr('type') !== 'radio') {
                        params[i] += '|' + $(this).val();
                    } else {
                        if ($(this).attr('type') === 'radio') {
                            if ($(this).is(':checked')) {
                                params[i] = $(this).val();
                            }
                        } else {
                            params[i] = $(this).val();
                        }
                    }
                });
                $.each(params, function (i, val) {
                    // apply search params to datatable
                    table.column(i).search(val ? val : '', false, false);
                });
                table.table().draw();
            });

            $('#kt_reset').on('click', function (e) {
                e.preventDefault();
                $('.selectedLength').html(0)
                $('.datatable-input').each(function () {
                    $(this).val('');
                    table.column($(this).data('col-index')).search('', false, false);
                });
                table.table().draw();
            });

            table.on('change', '.group-checkable', function () {
                var set = $(this).closest('table').find('td:first-child .checkable');
                var checked = $(this).is(':checked');
                var count = 0;
                $(set).each(function () {
                    if (checked) {
                        $(this).prop('checked', true);
                        table.rows($(this).closest('tr')).select();
                        count++;
                    } else {
                        $(this).prop('checked', false);
                        table.rows($(this).closest('tr')).deselect();
                    }

                });
                $('.selectedLength').html(count)
                console.log('ere')
            });

            table.on('page.dt', function () {
                $('.selectedLength').html(0)
            });


        };
        return {

            //main function to initiate the module
            init: function () {
                initTable1();
            },

        };

    }();

    jQuery(document).ready(function () {
        KTDatatablesSearchOptionsAdvancedSearch.init();
        $('#kt_datepicker').datepicker({
            todayHighlight: true,
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>',
            },
            format: 'yyyy-mm-dd'
        });

        $('.checkable').on('click', function () {
            $('.selectedLength').html($('.checkable').length)
        })
    });

</script>
