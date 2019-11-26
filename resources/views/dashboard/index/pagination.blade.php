<nav>
    <ul class="pagination">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true">@lang('pagination.previous')</span>
            </li>
        @else
            <li class="page-item">
                <button type="button" class="button-clickable page-link" rel="prev" role="button" aria-label="@lang('pagination.previous')" onclick="javascript:liveSearch('{{ $search['query'] }}', '{{ ($paginator->currentPage() - 1) }}', '{{ $search['orderBy'] }}', '{{ $search['direction'] === 'desc' ? 'asc' : 'desc' }}');">
                    @lang('pagination.previous')
                </button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <span>{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span>{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <button type="button" class="button-clickable page-link" role="button" onclick="javascript:liveSearch('{{ $search['query'] }}', '{{ $page }}', '{{ $search['orderBy'] }}', '{{ $search['direction'] === 'desc' ? 'asc' : 'desc' }}');">
                                {{ $page }}
                            </button>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <button type="button" class="button-clickable page-link" rel="next" role="button" aria-label="@lang('pagination.next')" onclick="javascript:liveSearch('{{ $search['query'] }}', '{{ ($paginator->currentPage() - 1) }}', '{{ $search['orderBy'] }}', '{{ $search['direction'] === 'desc' ? 'asc' : 'desc' }}');">
                    @lang('pagination.next')
                </button>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">@lang('pagination.next')</span>
            </li>
        @endif
    </ul>
</nav>
