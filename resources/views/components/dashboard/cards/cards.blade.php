@foreach($data['cards'] as $card)
    @switch($card['type'])
        @case($card['type'] == 'tabs')
        @component('components.dashboard.cards.tab_card' , ['data' => $card , 'action' => $action])@endcomponent
        @break
        @default
        @component('components.dashboard.cards.card', ['data' => $card  ,'action' => $action])@endcomponent
    @endswitch
@endforeach
{{ $slot }}
