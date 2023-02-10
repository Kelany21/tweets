{{-- Nav --}}

<ul class="navi navi-hover py-4">
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        {{-- Item --}}
        <li class="navi-item {{ LaravelLocalization::getCurrentLocale() === $localeCode  ? 'active' : '' }}">
            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="navi-link">
            <span class="symbol symbol-20 mr-3">
                <img src="{{ asset('media/svg/flags/'.$localeCode.'.svg') }}" alt=""/>
            </span>
                <span class="navi-text">{{ $properties['native'] }}</span>
            </a>
        </li>
    @endforeach
</ul>
