@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><a style="pointer-events:none;">@php(include ("mooimarkt/img/pagin-arrow-left.svg"))</a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}">@php(include ("mooimarkt/img/pagin-arrow-left.svg"))</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><a>{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a class="active" style="pointer-events:none;">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">@php(include ("mooimarkt/img/pagin-arrow-right.svg"))</a></li>
        @else
            <li><a style="pointer-events:none;">@php(include ("mooimarkt/img/pagin-arrow-right.svg"))</a></li>
        @endif
    </ul>
@endif

@if ($paginator->hasPages())
    <ul class="pagination pagination-mobile">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><a style="pointer-events:none;">@php(include ("mooimarkt/img/pagin-arrow-left.svg"))</a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}">@php(include ("mooimarkt/img/pagin-arrow-left.svg"))</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><a>{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a class="active" style="pointer-events:none;">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">@php(include ("mooimarkt/img/pagin-arrow-right.svg"))</a></li>
        @else
            <li><a style="pointer-events:none;">@php(include ("mooimarkt/img/pagin-arrow-right.svg"))</a></li>
        @endif
    </ul>
@endif