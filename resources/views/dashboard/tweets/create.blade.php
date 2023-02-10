{{-- Extends layout --}}
@extends('dashboard.layout.default')

{{-- Content --}}
@section('content')
    <form action="{{ uA($moduleRoute) }}" method="post" multiple="">
        @csrf
        @component('components.dashboard.layout._subheader-v1' , ['toolBar' => $toolBar ,'moduleRoute' => $moduleRoute, 'moduleName' => $moduleName , 'createBtnIcon' => $createBtnIcon , 'page_breadcrumbs' => $page_breadcrumbs])
            <x-dashboard.btn.update updateBtnIcon="{{ $createBtnIcon }}" label=""></x-dashboard.btn.update>
            <x-dashboard.btn.save-back updateBtnIcon="{{ $createBtnIcon }}" label=""></x-dashboard.btn.save-back>
        @endcomponent

        <x-dashboard.errors.errors></x-dashboard.errors.errors>

        <div class="row">
            @component('components.dashboard.cards.cards' , ['data' => $cards , 'action' => $action])@endcomponent
        </div>
    </form>
@endsection
