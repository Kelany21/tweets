@php $menu = request()->has('delete') ? $bulkAction['delete_menu'] : $bulkAction['menu']@endphp
@if(count($menu))
    <div class="btn-group">
        <button class="btn btn-success font-weight-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            {{ $bulkAction['title'] }} <span class="selectedLength">0</span>
        </button>
        <div class="dropdown-menu">
            @foreach($menu as $item)
                @if(in_array($item['permission'] , $modulePermissions))
                    <a class="dropdown-item px-8" id="{{ $item['id'] }}" href="#" data-href="{{ $item['action'] }}"
                       onclick="{{ isset($item['hasConfirm']) ? 'deleteRow(this , '. $item['id'] .' , '.json_encode($item['hasConfirm']).')' : 'execBulkAction(this , '. $item['id'] .')' }}">{{ $item['label'] }}</a>
                @endif
            @endforeach
            {{ $slot }}
        </div>
    </div>
@endif


@push('scripts')
    <script>
        var form = $('#index-form');

        /**
         * @param e
         * @param id
         */
        function execBulkAction(e, id) {
            e.preventDefault;
            form.attr('action', $(e).data('href'))
            form.submit();
        }

        /**
         * @param e
         * @param id
         * @param data
         */
        function deleteRow(e, id, data) {
            e.preventDefault;
            console.log(data)
            form.attr('action', $(e).data('href'))
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: data.confirmButtonText
            }).then(function (result) {
                if (result.value) {
                    form.submit();
                }
            });
        }
    </script>
@endpush
