@if ($paginator->hasPages())
    <nav
        class="flex items-center justify-between my-4"
        role="navigation"
        aria-label="{{ __('Pagination Navigation') }}"
    >
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm opacity-50 leading-5">
                    {{ __('Results') }}
                    @if ($paginator->firstItem())
                        <span class="font-medium"
                        >{{ \BondarDe\Lox\Support\NumbersFormatter::format($paginator->firstItem()) }}</span>
                        {!! __('to') !!}
                        <span class="font-medium"
                        >{{ \BondarDe\Lox\Support\NumbersFormatter::format($paginator->lastItem()) }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium"
                    >{{ \BondarDe\Lox\Support\NumbersFormatter::format($paginator->total()) }}</span>
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span
                            aria-disabled="true"
                            aria-label="{{ __('pagination.previous') }}"
                        >
                            <span
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium opacity-25 bg-white border border-gray-300 cursor-default rounded-l-md leading-5"
                                aria-hidden="true"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </span>
                    @else
                        <a
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium rounded-l-md leading-5
                                text-gray-500 bg-white border border-gray-300 ring-gray-300
                                dark:bg-gray-900 dark:border-gray-700
                                hover:text-gray-900 hover:dark:text-gray-100
                                focus:z-10 focus:outline-none focus:ring focus:border-blue-300
                                active:bg-gray-100 active:text-gray-500
                                transition ease-in-out duration-150"
                            href="{{ $paginator->previousPageUrl() }}"
                            rel="prev"
                            aria-label="{{ __('pagination.previous') }}"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium border cursor-default leading-5
                                        text-gray-700 bg-white border-gray-300
                                        dark:bg-gray-900 dark:border-gray-700
                                        "
                                >{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold border cursor-default leading-5
                                                text-gray-700 bg-gray-200 border-gray-300
                                                dark:text-gray-200 dark:bg-gray-800/90 dark:border-gray-700
                                            "
                                        >{{ $page }}</span>
                                    </span>
                                @else
                                    <a
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-md font-medium border leading-5
                                            text-gray-500 bg-white border-gray-300 ring-gray-300
                                            dark:bg-gray-900 dark:border-gray-700
                                            hover:text-gray-900 dark:hover:text-gray-100 _dark:hover:bg-gray-800
                                            focus:z-10 focus:outline-none focus:ring focus:border-blue-300
                                            active:bg-gray-100 active:text-gray-700
                                            transition ease-in-out duration-150"
                                        href="{{ $url }}"
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                                    >
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a
                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium border rounded-r-md leading-5
                                text-gray-500 bg-white border-gray-300 ring-gray-300
                                dark:bg-gray-900 dark:border-gray-700
                                hover:text-gray-900 hover:dark:text-gray-100
                                focus:z-10 focus:outline-none focus:ring focus:border-blue-300
                                active:bg-gray-100 active:text-gray-500
                                transition ease-in-out duration-150"
                            href="{{ $paginator->nextPageUrl() }}"
                            rel="next"
                            aria-label="{{ __('pagination.next') }}"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @else
                        <span
                            aria-disabled="true"
                            aria-label="{{ __('pagination.next') }}"
                        >
                            <span
                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium opacity-25 bg-white border border-gray-300 cursor-default rounded-r-md leading-5"
                                aria-hidden="true"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
