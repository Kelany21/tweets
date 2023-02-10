<div class="subheader py-2 {{ Metronic::printClasses('subheader', false) }}" id="kt_subheader">
    <div
        class="{{ Metronic::printClasses('subheader-container', false) }} d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        {{-- Info --}}
        <div class="d-flex align-items-center flex-wrap mr-1">
            @component('components.dashboard.btn.trashed' )
            @endcomponent
            @if (!empty($page_breadcrumbs))
                {{-- Separator --}}
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                {{-- Breadcrumb --}}
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2">
                    @foreach ($page_breadcrumbs as $k => $item)
                        <li class="breadcrumb-item">
                            <a href="{{ url($item['page']) }}" class="text-muted">
                                <i class="{{ $item['icon'] }} {{ $loop->first ?: ' ml-3' }} mr-3"></i>
                                {{ $item['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Toolbar --}}
        <div class="d-flex align-items-center">
        {{ $slot }}
        @if(!request()->get('delete'))
            @if($toolBar['createBtn'])
                <!--begin::Button-->
                    <a href="{{ uA($moduleRoute.'/create') }}"
                       class="btn btn-warning font-weight-bolder btn-sm ml-3 mr-3">
                        <i class="{{ $createBtnIcon }}"></i>
                        {{ trans('admin.create') }}
                    </a>
                    <!--end::Button-->
                @endif
            @endif
        </div>

    </div>
</div>
