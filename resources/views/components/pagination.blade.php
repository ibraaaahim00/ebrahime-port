@if ($paginator->hasPages())
    <nav class="pagination" aria-label="{{ __('ui.pagination') }}">
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true">{{ app()->isLocale('ar') ? '→' : '←' }}</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('ui.previous') }}">{{ app()->isLocale('ar') ? '→' : '←' }}</a>
        @endif

        <span class="pagination-label">{{ __('ui.page_of', ['current' => $paginator->currentPage(), 'last' => $paginator->lastPage()]) }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('ui.next') }}">{{ app()->isLocale('ar') ? '←' : '→' }}</a>
        @else
            <span class="disabled" aria-disabled="true">{{ app()->isLocale('ar') ? '←' : '→' }}</span>
        @endif
    </nav>
@endif
