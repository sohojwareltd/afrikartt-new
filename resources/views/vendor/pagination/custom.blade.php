<style>
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        width: 100%;
    }

    .pagination-list {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 0;
        margin: 0;
        justify-content: center;
    }

    .pagination-list li {
        display: flex;
    }

    .pagination-list li a,
    .pagination-list li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 8px;
        border: 1px solid var(--border-primary);
        background-color: var(--bg-light);
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px var(--shadow-light);
    }

    .pagination-list li a:hover {
        background-color: var(--btn-primary-hover);
        border-color: var(--btn-primary-hover);
        color: var(--text-light);
        box-shadow: 0 3px 6px var(--shadow-primary);
    }

    .pagination-list li.active span {
        background-color: var(--btn-primary);
        border-color: var(--btn-primary);
        color: var(--text-light);
        cursor: default;
        box-shadow: 0 3px 6px var(--shadow-primary);
    }

    .pagination-list li.disabled span {
        background-color: var(--bg-secondary);
        color: var(--text-muted);
        border-color: var(--border-medium);
        cursor: not-allowed;
    }

    /* ✅ RESPONSIVE ADJUSTMENTS */
    @media (max-width: 768px) {
        .pagination-list {
            gap: 4px;
        }

        .pagination-list li a,
        .pagination-list li span {
            min-width: 32px;
            height: 32px;
            font-size: 13px;
            padding: 0 8px;
            border-radius: 6px;
        }
    }

    @media (max-width: 480px) {

        .pagination-list li a,
        .pagination-list li span {
            min-width: 28px;
            height: 28px;
            font-size: 12px;
            border-radius: 5px;
        }

        .pagination-wrapper {
            margin-top: 1.5rem;
        }
    }
</style>
@if ($paginator->hasPages())
    <nav class="pagination-wrapper" role="navigation" aria-label="Pagination">
        <ul class="pagination-list">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
