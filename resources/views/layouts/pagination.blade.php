@if ($paginator->lastPage() > 1)
    <ul class="pagination justify-content-center">
        <li>
            <a href="{{ $paginator->url(1) }}" class=" btn btn-outline-p {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"><<</a>
        </li>&nbsp;
        <li>
            <a href="{{ $paginator->url($paginator->currentPage() - 1) }}" class=" btn btn-outline-p {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"><</a>
        </li>&nbsp;
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li>
                <a href="{{ $paginator->url($i) }}" class=" btn btn-outline-p {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
            </li>&nbsp;
        @endfor
        <li>
            <a href="{{ $paginator->url($paginator->currentPage() + 1) }}"  class=" btn btn-outline-p {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">></a>
        </li>&nbsp;
        <li>
            <a href="{{ $paginator->url($paginator->lastPage()) }}"  class=" btn btn-outline-p {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">>></a>
        </li>
    </ul>
@endif
