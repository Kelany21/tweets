@php
    $dataAll['name'] = 'permissions[]';
    $dataAll['labelKey'] = 'permission';
    $dataAll['valueKey'] = 'status';
    $dataAll['value'] = [1,2,4];
    $permissions = $permissions->groupBy('controller' , 'permission');

@endphp
@foreach($permissions as $key => $permission)
    @php $dataAll['label'] = trans('admin.'.$key) @endphp
    @php $dataAll['options'] = $permission @endphp
    @include('components.dashboard.inputs.checkbox' , ['data' => $dataAll])
@endforeach



