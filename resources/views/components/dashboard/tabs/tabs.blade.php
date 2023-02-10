<div class="card-header card-header-tabs-line ">
    <div class="card-toolbar">
        <ul class="nav nav-tabs nav-bold nav-tabs-line">
            @foreach($tabs as $tab)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#{{ $tab['id']  }}">
                        <span class="nav-icon">{!! $tab['icon']  !!}</span>
                        <span class="nav-text">{{ $tab['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="card-body">
    <div class="tab-content">
        @foreach($tabs as $tab)
            <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" id="{{ $tab['id']  }}" role="tabpanel"
                 aria-labelledby="{{ $tab['id']  }}">
                @isset($tab['content']['inputs'])
                    @foreach($tab['content']['inputs'] as $input)
                        @include('dashboard.components.form.inputs' , ['input' => $input])
                    @endforeach
                @endisset
            </div>
        @endforeach
    </div>
</div>
