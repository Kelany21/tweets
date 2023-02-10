@if($data['search'])
    <form class="pt-9" style="width: 100%;">
        <div class="row pt-9" style="width: 100%;">
            @foreach($data['inputs'] as $input)
                @include('components.dashboard.form.filters' , ['input' => $input])
            @endforeach
            <div class="col-lg-1">
                <div class="form-group" style="margin-top: 1.75rem;">
                    <button class="btn btn-icon btn-success btn-circle btn-sm " data-toggle="tooltip" data-theme="dark" title="{{ trans('admin.search') }}" id="kt_search">
						<span>
							<i class="la la-search"></i>
						</span>
                    </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-icon btn-danger btn-circle btn-sm " data-toggle="tooltip" data-theme="dark" title="{{ trans('admin.reset') }}"  id="kt_reset">
						<span>
							<i class="la la-close"></i>
						</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    {{ $slot }}
@endif
