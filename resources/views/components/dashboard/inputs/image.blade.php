@php
    $id = str_replace('[]', '', $data['name']);
@endphp

<div class="@isset($data['class']) {{ $data['class'] }} @endisset mb-3 mt-3">
    <div for="" class="d-inline-block mb-3 ">{{ $data['label'] }}</div>
    <div class="input-group ">
        <div class="image-input image-input-outline" id="kt_image_3">
            <img src="{{ $data['value'] ?? defaultImage() }}" id="preview" alt=""
                 class="image-input-wrapper preview-image">
            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                   data-action="change"
                   data-toggle="modal" onclick="openUploadModel(this)"
                   data-original-title="{{ trans('admin.file_manager') }}">
                <i class="fa fa-pen icon-sm text-muted" data-toggle="tooltip"
                   data-original-title="{{ trans('admin.file_manager') }}"></i>
            </label>
            <span class="btn btn-xs btn-icon btn-circle  btn-white btn-hover-text-primary btn-shadow cancel-image"
                  onclick="cancelImage(this)" data-action="cancel" data-toggle="tooltip" title=""
                  data-original-title="Cancel avatar">
            <i class="ki ki-bold-close icon-xs text-muted"></i>
        </span>
        </div>
        <input type="hidden" id="{{ $id }}" class="form-control hiddenInput" value="{{ $data['value'] }}"
               name="{{ $data['name'] }}" aria-label="Image" aria-describedby="button-image">
    </div>
    <x-dashboard.errors.input-error name="{{ $data['name'] }}"></x-dashboard.errors.input-error>
    @isset($data['hint'])
        <div class="form-text text-mutedc mt-3">{{$data['hint']}}</div>
    @endisset
</div>


