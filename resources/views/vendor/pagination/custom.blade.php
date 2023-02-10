@if ($paginator->hasPages())
    <div class="container">
        <div class="pagination_row">
            <nav aria-label="...">
                <ul class="pagination">

                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">@lang('pagination.previous')</a>
                        </li>
                    @else
                        <li class="page-item ">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                               tabindex="-1">@lang('pagination.previous')</a>
                        </li>
                    @endif


                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true">{{ $element }}</li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">{{ $page }}</a></li>
                                @else
                                    <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach


                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                               aria-label="@lang('pagination.next')">@lang('pagination.next')</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            @lang('pagination.next')
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </div>
@endif
