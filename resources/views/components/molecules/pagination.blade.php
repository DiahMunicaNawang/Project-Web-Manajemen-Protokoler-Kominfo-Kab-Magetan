@if ($paginator->hasPages())
    <div class="row mb-7 pb-5">
        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
            <div class="dataTables_paginate paging_simple_numbers" id="custom-pagination">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="paginate_button page-item previous disabled" id="pagination_previous"><span
                                class="page-link prev-next"><i class="previous"></i></span></li>
                    @else
                        <li class="paginate_button page-item previous" id="pagination_previous"><a
                                href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"
                                class="page-link prev-next"><i class="previous"></i></a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $totalPages = $paginator->lastPage();
                        $currentPage = $paginator->currentPage();
                        $startPage = max($currentPage - 2, 1);
                        $endPage = min($currentPage + 2, $totalPages);
                    @endphp

                    @if ($startPage > 1)
                        <li class="paginate_button page-item"><a href="{{ $paginator->url(1) }}" class="page-link">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="paginate_button page-item disabled" aria-disabled="true"><span
                                    class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        @if ($i == $currentPage)
                            <li class="paginate_button page-item active" aria-current="page"><span
                                    class="page-link">{{ $i }}</span></li>
                        @else
                            <li class="paginate_button page-item"><a href="{{ $paginator->url($i) }}"
                                    class="page-link">{{ $i }}</a></li>
                        @endif
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="paginate_button page-item disabled" aria-disabled="true"><span
                                    class="page-link">...</span></li>
                        @endif
                        <li class="paginate_button page-item"><a href="{{ $paginator->url($totalPages) }}"
                                class="page-link">{{ $totalPages }}</a></li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="paginate_button page-item next" id="pagination_next"><a
                                href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"
                                class="page-link prev-next"><i class="next"></i></a></li>
                    @else
                        <li class="paginate_button page-item next disabled" id="pagination_next"><span
                                class="page-link prev-next"><i class="next"></i></span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
