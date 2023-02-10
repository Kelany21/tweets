<ul class="nav nav-tabs nav-bold nav-tabs-line">
    @foreach($data as $tab)
        @php
            $allowInEditInTab = isset($tab['showOnEdit']) ? $tab['showOnEdit']: true;
            $allowInCreateInTab = isset($tab['showOnCreate']) ? $tab['showOnCreate'] : true;
        @endphp
        @if(($allowInEditInTab && $action == 'edit') || ($allowInCreateInTab && $action == 'create') || $action == 'list')
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#{{ $tab['id']  }}">
                    @isset($tab['icon'])<span class="nav-icon"><i
                            class="{{$tab['icon'] }}">@isset($tab['iconContent']) {{ $tab['iconContent'] }} @endisset</i></span>@endisset
                    <span class="nav-text">{{ $tab['label'] }}</span>
                    <span id="{{ $tab['id']  }}HeaderTab"></span>
                </a>
            </li>
        @endif
    @endforeach
</ul>
