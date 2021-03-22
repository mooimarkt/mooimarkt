@if ($paginator->hasPages())
    <div class="recent-pagin-mob pagin-list">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="rec_next_prev" style="pointer-events:none;">@php echo \App\Language::GetText(233); @endphp</a>
        @else
            <a class="rec_next_prev" href="{{ $paginator->previousPageUrl() }}">@php echo \App\Language::GetText(233); @endphp</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a style="pointer-events:none;">{{ $element }}</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="active_pagin" style="pointer-events:none;">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="rec_next_prev" href="{{ $paginator->nextPageUrl() }}">@php echo \App\Language::GetText(234); @endphp</a>
        @else
            <a class="rec_next_prev" style="pointer-events:none;">@php echo \App\Language::GetText(234); @endphp</a>
        @endif
    </div>
@endif
