@if($allowDelete)
    @if(!in_array($id , $notAllowToDelete))
        <a href="{{ uA($moduleName.'/'.$id.'/delete') }}" class="btn btn-danger ml-3 btn-sm">
            <i class="{{ $deleteBtnIcon ?? 'fa fa-trash' }}"></i> {{ trans('admin.delete') }} {{ $label }} {{ $slot }}
        </a>
    @endif
@endif
