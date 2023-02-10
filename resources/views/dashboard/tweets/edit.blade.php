{{-- Extends layout --}}
@extends('dashboard.layout.default')

{{-- Content --}}
@section('content')
    <form action="{{ uA($moduleRoute.'/'.$row->id) }}" method="post" multiple="">
        @csrf
        @method('put')
        @php array_push($page_breadcrumbs  ,['title' => $row->name ,'page' => '' , 'icon' => 'flaticon-users']) @endphp
        @component('components.dashboard.layout._subheader-v1' , ['toolBar' => $toolBar ,'moduleRoute' => $moduleRoute , 'moduleName' => $moduleName , 'createBtnIcon' => $createBtnIcon , 'page_breadcrumbs' => $page_breadcrumbs])
            <x-dashboard.btn.update updateBtnIcon="{{ $updateBtnIcon }}" label=""></x-dashboard.btn.update>
            <x-dashboard.btn.save-back updateBtnIcon="{{ $updateBtnIcon }}" label=""></x-dashboard.btn.save-back>
            @component('components.dashboard.btn.delete' , ['moduleName' => $moduleName , 'id' => $row->id , 'allowDelete' =>  $allowDelete , 'notAllowToDelete' => $notAllowToDelete , 'deleteBtnIcon' => '' , 'label' => '' ])
            @endcomponent
        @endcomponent

        <x-dashboard.errors.errors></x-dashboard.errors.errors>

        <div class="row">
            @component('components.dashboard.cards.cards' , ['data' => $cards , 'action' => $action])@endcomponent
        </div>
    </form>
@endsection
