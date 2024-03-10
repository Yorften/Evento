<x-app-layout>
    @push('vite')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    @endpush
    <div
        class="bg-header bg-center bg-cover bg-no-repeat h-[10vh] md:h-[15vh] mx-auto flex flex-col justify-center text-gray-900">
        <div class="w-[95%] md:w-[85%] lg:w-9/12 mx-auto flex items-center flex-wrap">
            <ul class="flex items-center">
                <li class="inline-flex items-center">
                    <a href="/" class="hover:text-fuchsia-700">
                        <svg class="w-5 h-auto fill-current " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="#000000">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z" />
                        </svg>
                    </a>
                    <span class="mx-4 h-auto text-gray-400 font-medium">/</span>
                </li>
                <li class="inline-flex items-center">
                    <a href="{{ route('events.index') }}" class="hover:text-fuchsia-700">Events</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="w-[95%] md:w-[90%] lg:w-[80%] min-h-[85vh] mx-auto flex flex-col mb-20 gap-8 text-gray-900">
        <p class="text-3xl font-semibold my-4">Browse Events</p>
        <form method="GET" class="w-full flex items-center justify-between gap-4">
            <div class="flex items-center w-3/5 md:w-1/3 gap-4">
                <select name="category" id="categories" style="width: full;"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    <option value="all">All</option>
                    @unless (count($categories) == 0)
                        @foreach ($categories as $category)
                            <option {{ ($category_filter ? $category_filter : 0) == $category->id ? 'Selected' : '' }}
                                value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @else
                        <option value="" disabled>No categories found</option>
                    @endunless
                </select>
            </div>
            <button
                class="inline-flex text-white items-center px-4 py-1 bg-fuchsia-600 bgindi hover:bg-fuchsia-500 text-sm font-medium rounded-md">
                <i class='bx bx-filter font-semibold text-lg'></i>
                Filter
            </button>
        </form>
        <div class="w-full min-h-[60vh] border shadow-lg flex flex-col justify-between gap-8 p-4">
            <x-search-input />
            @unless (count($events) == 0)
                <div id="content" class="grid place-items-center grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($events as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
                <div id="links">
                    {{ $events->appends(['category' => $category_filter, 'title' => request()->input('title')])->links() }}
                </div>
            @else
                <p class="w-full h-full self-center text-center text-xl font-semibold">No events found
                </p>
                <div></div>
            @endunless

        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#categories').select2({
                    width: '100%',
                });
            });
        </script>
        <script src="{{ asset('js/search.js') }}"></script>
    @endpush
</x-app-layout>
