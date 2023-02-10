{{-- Extends layout --}}
@extends('dashboard.layout.default')


@section('content')
    @component('components.dashboard.layout._subheader-v1' , ['toolBar' => $toolBar , 'moduleName' => $moduleName , 'createBtnIcon' => $createBtnIcon , 'page_breadcrumbs' => $page_breadcrumbs])

    @endcomponent

    <div class="row">
        <div class="col-12">
        <x-dashboard.count-cards.all>@include('dashboard.home.statistics')</x-dashboard.count-cards.all>
        </div>
        <div class="col-6">
            @include('dashboard.home.most-user-seen')
        </div>
        <div class="col-6">
            @include('dashboard.home.most-tweet-seen')
        </div>
    </div>

@endsection

@push('scripts')
@endpush
