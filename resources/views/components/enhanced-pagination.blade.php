@if($paginator->hasPages())
<div class="enhanced-pagination-wrapper">
    <!-- Page Info -->
    @if($showPageInfo)
    <div class="pagination-info">
        <span class="page-info-text">{{ $getPageInfo() }}</span>
    </div>
    @endif

    <!-- Per Page Selector -->
    @if($showPerPageSelector)
    <div class="per-page-selector">
        <label for="per-page-select" class="per-page-label">Show:</label>
        <select id="per-page-select" class="per-page-select" onchange="changePerPage(this.value)">
            @foreach($perPageOptions as $option)
            <option value="{{ $option }}" @if($getCurrentPerPage()==$option) selected @endif>
                {{ $option }}
            </option>
            @endforeach
        </select>
        <span class="per-page-text">per page</span>
    </div>
    @endif

    <!-- Pagination Controls -->
    <div class="pagination-controls">
        <!-- First Page -->
        @if($paginator->onFirstPage())
        <span class="pagination-btn pagination-btn-disabled" title="First Page">
            <i class="fas fa-angle-double-left"></i>
        </span>
        @else
        <a href="{{ $paginator->url(1) }}" class="pagination-btn" title="First Page">
            <i class="fas fa-angle-double-left"></i>
        </a>
        @endif

        <!-- Previous Page -->
        @if($paginator->onFirstPage())
        <span class="pagination-btn pagination-btn-disabled" title="Previous Page">
            <i class="fas fa-angle-left"></i>
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" title="Previous Page">
            <i class="fas fa-angle-left"></i>
        </a>
        @endif

        <!-- Page Numbers -->
        @if($shouldShowFirstPage())
        <a href="{{ $paginator->url(1) }}" class="pagination-btn">1</a>
        @if($getVisiblePages()[0] > 2)
        <span class="pagination-ellipsis">...</span>
        @endif
        @endif

        @foreach($getVisiblePages() as $page)
        @if($page == $paginator->currentPage())
        <span class="pagination-btn pagination-btn-active">{{ $page }}</span>
        @else
        <a href="{{ $paginator->url($page) }}" class="pagination-btn">{{ $page }}</a>
        @endif
        @endforeach

        @if($shouldShowLastPage())
        @php $visiblePages = $getVisiblePages(); @endphp
        @if(end($visiblePages) < $paginator->lastPage() - 1)
            <span class="pagination-ellipsis">...</span>
            @endif
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-btn">{{ $paginator->lastPage() }}</a>
            @endif

            <!-- Next Page -->
            @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" title="Next Page">
                <i class="fas fa-angle-right"></i>
            </a>
            @else
            <span class="pagination-btn pagination-btn-disabled" title="Next Page">
                <i class="fas fa-angle-right"></i>
            </span>
            @endif

            <!-- Last Page -->
            @if($paginator->hasMorePages())
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-btn" title="Last Page">
                <i class="fas fa-angle-double-right"></i>
            </a>
            @else
            <span class="pagination-btn pagination-btn-disabled" title="Last Page">
                <i class="fas fa-angle-double-right"></i>
            </span>
            @endif
    </div>

    <!-- Jump to Page -->
    @if($showJumpToPage && $paginator->lastPage() > 1)
    <div class="jump-to-page">
        <label for="jump-to-input" class="jump-label">Go to:</label>
        <input type="number" id="jump-to-input" class="jump-input" min="1" max="{{ $paginator->lastPage() }}"
            placeholder="Page" onkeypress="handleJumpToPage(event)" data-max-page="{{ $paginator->lastPage() }}">
        <button type="button" class="jump-btn" onclick="jumpToPage()" title="Go to Page">
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>
    @endif
</div>

<!-- Pagination JavaScript -->
@push('scripts')
<script>
    function changePerPage(perPage) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page'); // Reset to first page
        window.location.href = url.toString();
    }

    function handleJumpToPage(event) {
        if (event.key === 'Enter') {
            jumpToPage();
        }
    }

    function jumpToPage() {
        const input = document.getElementById('jump-to-input');
        const page = parseInt(input.value);
        const maxPage = parseInt(input.dataset.maxPage);

        if (page >= 1 && page <= maxPage) {
            const url = new URL(window.location);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        } else {
            if (typeof showError === 'function') {
                showError('Please enter a valid page number between 1 and ' + maxPage);
            } else {
                alert('Please enter a valid page number between 1 and ' + maxPage);
            }
            input.focus();
        }
    }
</script>
@endpush
@endif