
@foreach($statuses  as $status)
    @php $url = str_contains($status['label'] , 'deleted') ? '' : uA($status['module']); @endphp
<x-dashboard.count-cards.state-count-wave color="{{ $status['color'] }}" url="{{ $url }}" icon="{{ $status['icon'] }}" count="{{ $status['count'] }}" title="{{ trans('admin.'.$status['label']) }}"
                              col="2"></x-dashboard.count-cards.state-count-wave>
@endforeach
