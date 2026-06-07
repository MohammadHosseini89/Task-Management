<div class="flex justify-between">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="mr-2 text-gray-400" aria-disabled="true">{!! __('&laquo; Previous') !!}</span>
    @else
        <button wire:click="previousPage" class="mr-2">{!! __('&laquo; Previous') !!}</button>
    @endif
    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <button wire:click="nextPage" class="ml-2">{!! __('Next &raquo;') !!}</button>
    @else
        <span class="ml-2 text-gray-400" aria-disabled="true">{!! __('Next &raquo;') !!}</span>
    @endif
</div>

<div class="hidden sm:flex ml-4">
    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span class="mx-2">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="mx-2 font-bold">{{ $page }}</span>
                @else
                    <button wire:click="gotoPage({{ $page }})" class="mx-2">{{ $page }}</button>
                @endif
            @endforeach
        @endif
    @endforeach
</div>
