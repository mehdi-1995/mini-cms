{{--
|--------------------------------------------------------------------------
| Custom Pagination View
|--------------------------------------------------------------------------
| This view is rendered via:
|   {{ $paginator->links('vendor.pagination.custom') }}
|
| Variables provided automatically by Laravel:
| - $paginator : LengthAwarePaginator instance (pages, URLs, meta)
| - $elements  : Pagination elements (page numbers & separators)
|
| Purpose:
| - Custom RTL pagination
| - Tailwind-based styling
| - Admin-friendly numbered navigation
|--------------------------------------------------------------------------
--}}

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col items-center gap-4 mt-6">

        {{-- دکمه‌ها --}}
        <div class="flex items-center gap-1" style="direction: rtl">
            {{-- قبلی --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1 text-gray-400 border rounded cursor-not-allowed">
                    قبلی
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 border rounded hover:bg-gray-100">
                    قبلی
                </a>
            @endif

            {{-- شماره صفحات --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1 text-gray-400">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 text-white bg-blue-600 border border-blue-600 rounded">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1 border rounded hover:bg-gray-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- بعدی --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 border rounded hover:bg-gray-100">
                    بعدی
                </a>
            @else
                <span class="px-3 py-1 text-gray-400 border rounded cursor-not-allowed">
                    بعدی
                </span>
            @endif
        </div>

        {{-- متن بالا --}}
        <div class="text-sm text-gray-600">
            نمایش
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            تا
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            از
            <span class="font-medium">{{ $paginator->total() }}</span>
            نتیجه
        </div>

    </nav>
@endif
