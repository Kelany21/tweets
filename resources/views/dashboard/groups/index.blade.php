{{-- Extends layout --}}
@extends('dashboard.layout.default')

{{-- Content --}}
@section('content')
    <form action="" id="index-form" method="post">
        @csrf
        @component('components.dashboard.layout._subheader-v1' , ['toolBar' => $toolBar ,'moduleRoute' => $moduleRoute , 'moduleName' => $moduleName , 'createBtnIcon' => $createBtnIcon , 'page_breadcrumbs' => $page_breadcrumbs])
            @component('components.dashboard.drop-down.drop-down' , ['bulkAction' => $bulkAction , 'modulePermissions' => $modulePermissions])
            @endcomponent
        @endcomponent
        <x-dashboard.count-cards.all moduleIcon="{{ $moduleIcon }}" moduleName="{{ $moduleName }}">
            @include('dashboard.groups.statistics')
        </x-dashboard.count-cards.all>

        <div class="card card-custom card-sticky" id="kt_page_sticky_card">
            <div class="card-header">
                @component('components.dashboard.index.search' , ['data' => $search]) @endcomponent
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        @foreach($table as $th)
                            <th>{{ $th['label'] }}</th>
                        @endforeach
                        <th>{{ trans('admin.created-at') }}</th>
                        <th>{{ trans('admin.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    @include('components.dashboard.index.js.scripts')
    @include('dashboard.groups.render-functions.name')
    @include('components.dashboard.index.js.datatable' , ['data' => $moduleRoute ])
@endsection
