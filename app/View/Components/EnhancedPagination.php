<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class EnhancedPagination extends Component
{
    public $paginator;
    public $showPerPageSelector;
    public $perPageOptions;
    public $showPageInfo;
    public $showJumpToPage;
    public $maxVisiblePages;

    /**
     * Create a new component instance.
     */
    public function __construct(
        LengthAwarePaginator $paginator,
        bool $showPerPageSelector = true,
        array $perPageOptions = [5, 10, 20, 50, 100],
        bool $showPageInfo = true,
        bool $showJumpToPage = true,
        int $maxVisiblePages = 7
    ) {
        $this->paginator = $paginator;
        $this->showPerPageSelector = $showPerPageSelector;
        $this->perPageOptions = $perPageOptions;
        $this->showPageInfo = $showPageInfo;
        $this->showJumpToPage = $showJumpToPage;
        $this->maxVisiblePages = $maxVisiblePages;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.enhanced-pagination');
    }

    /**
     * Get the visible page numbers for pagination.
     */
    public function getVisiblePages()
    {
        $currentPage = $this->paginator->currentPage();
        $lastPage = $this->paginator->lastPage();
        $maxVisible = $this->maxVisiblePages;

        if ($lastPage <= $maxVisible) {
            return range(1, $lastPage);
        }

        $half = floor($maxVisible / 2);
        $start = max(1, $currentPage - $half);
        $end = min($lastPage, $start + $maxVisible - 1);

        if ($end - $start + 1 < $maxVisible) {
            $start = max(1, $end - $maxVisible + 1);
        }

        return range($start, $end);
    }

    /**
     * Check if we should show the first page.
     */
    public function shouldShowFirstPage()
    {
        return $this->getVisiblePages()[0] > 1;
    }

    /**
     * Check if we should show the last page.
     */
    public function shouldShowLastPage()
    {
        $visiblePages = $this->getVisiblePages();
        return end($visiblePages) < $this->paginator->lastPage();
    }

    /**
     * Get the current per page value.
     */
    public function getCurrentPerPage()
    {
        return $this->paginator->perPage();
    }

    /**
     * Get the page info text.
     */
    public function getPageInfo()
    {
        $start = $this->paginator->firstItem();
        $end = $this->paginator->lastItem();
        $total = $this->paginator->total();

        if ($start && $end) {
            return "Showing {$start} to {$end} of {$total} results";
        }

        return "No results found";
    }
}
