<style>
    .pagination .page-link {
    cursor: pointer !important;
}
.pagination .page-item.disabled .page-link {
    cursor: not-allowed !important;
}

</style>


@if ($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-none d-md-block">
            {{-- Showing x to y of z results hanya tampil di desktop --}}
            <small>
                Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
            </small>
        </div>

        <ul class="pagination justify-content-end mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" wire:click.prevent="gotoPage({{ $paginator->currentPage() - 1 }})">&laquo;</a>
                </li>
            @endif

            {{-- Custom number links --}}
            @php
                $total = $paginator->lastPage();
                $current = $paginator->currentPage();
                $start = max($current - 1, 1);
                $end = min($current + 1, $total);
            @endphp

            @if ($start > 1)
                <li class="page-item">
                    <a class="page-link" wire:click.prevent="gotoPage(1)">1</a>
                </li>
            @endif

            @if ($start > 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $current)
                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" wire:click.prevent="gotoPage({{ $i }})">{{ $i }}</a></li>
                @endif
            @endfor

            @if ($end < $total - 1)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            @if ($end < $total)
                <li class="page-item">
                    <a class="page-link" wire:click.prevent="gotoPage({{ $total }})">{{ $total }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" wire:click.prevent="gotoPage({{ $paginator->currentPage() + 1 }})">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </div>
@endif
