<x-app-layout>
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-[90vh]">
            <!-- Item 1 -->
            <div class="hidden duration-500 ease-in" data-carousel-item="active">
                <img src="{{ asset('assets/images/carousel_1.png') }}"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-500 ease-in" data-carousel-item>
                <img src="{{ asset('assets/images/carousel_2.jpg') }}"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-500 ease-in" data-carousel-item>
                <img src="{{ asset('assets/images/carousel_3.jpeg') }}"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-500 ease-in" data-carousel-item>
                <img src="{{ asset('assets/images/carousel_4.png') }}"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-500 ease-in" data-carousel-item>
                <img src="{{ asset('assets/images/carousel_5.jpeg') }}"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 space-x-3 rtl:space-x-reverse bottom-5 left-1/2">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                data-carousel-slide-to="3"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                data-carousel-slide-to="4"></button>
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
    @php
        $eventsByDate = $events->groupBy(function ($event) {
            return $event->date->format('Y-m-d');
        });
    @endphp

    <div class="w-11/12 ml-9 flex flex-col items-start justify-start my-24 text-gray-900">
        <p class="text-5xl font-semibold my-4">Upcoming Events</p>
        @unless (count($eventsByDate) == 0)
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
                    data-tabs-toggle="#default-styled-tab-content"
                    data-tabs-active-classes="text-purple-600 hover:text-purple-600 border-purple-600"
                    data-tabs-inactive-classes="text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300"
                    role="tablist">
                    @foreach ($eventsByDate as $date => $events)
                        @if ($loop->index < 7)
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="{{ 'day-' . $loop->index }}"
                                    data-tabs-target="{{ '#day-' . $loop->index . '-content' }}" type="button"
                                    role="tab" aria-controls="{{ 'day-' . $loop->index }}-content"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ \Carbon\Carbon::parse($date)->format('l') }}
                                </button>
                            </li>
                        @endif
                    @endforeach

                </ul>
            </div>

            <div id="default-styled-tab-content">
                @foreach ($eventsByDate as $date => $events)
                    @if ($loop->index < 7)
                        <div class="hidden p-4 rounded-lg shadow-xl bg-gray-50 w-[90%] md:w-4/5"
                            id="{{ 'day-' . $loop->index . '-content' }}" role="tabpanel"
                            aria-labelledby="{{ 'day-' . $loop->index }}">
                            <ul class="flex flex-col gap-12">
                                @foreach ($events as $event)
                                    <li>
                                        <div class="flex flex-col md:flex-row gap-4">
                                            @if (!$event->images == null)
                                                <img src="{{ asset('assets/images/poster.jpg') }}"
                                                    class="w-full md:w-[30%] h-full inline-block shrink-0 rounded-2xl"
                                                    alt="">
                                            @else
                                                <img src="{{ asset('storage/' . $event->image->path) }}"
                                                    class="w-full md:w-[30%] h-full inline-block shrink-0 rounded-2xl"
                                                    alt="">
                                            @endif
                                            <div class="flex flex-col justify-between">
                                                <div class="w-full flex justify-between items-center">
                                                    <div class="flex flex-col gap-1">
                                                        <a href="{{ route('events.show', $event->id) }}"
                                                            class="text-3xl hover:text-purple-600 font-semibold">{{ $event->title }}
                                                        </a>
                                                        <div class="flex items-center gap-1">
                                                            @if ($event->category == null)
                                                                <p
                                                                    class="capitalize cursor-default text-sm p-1 rounded-xl border border-gray-500 text-gray-500">
                                                                    {{ $event->category->name }}</p>
                                                            @else
                                                                <p
                                                                    class="capitalize cursor-default text-sm p-1 rounded-xl border border-gray-500 text-gray-500">
                                                                    {{ $event->category->name }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-semibold">Description:</p>
                                                    <p class="rounded-md border shadow-md">
                                                        {{ substr($event->description, 0, 120) }}...
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-semibold">Event starts at:</p>
                                                    <div class="flex items-center gap-1">
                                                        <p
                                                            class="capitalize cursor-default font-semibold text-sm p-1 px-2 rounded-xl border bg-purple-600 border-purple-500 text-gray-200">
                                                            {{ $event->date->format('d-m-Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="p-4 border-t-2 rounded-lg shadow-xl bg-gray-50 w-[90%] md:w-4/5">
                <p class="w-full text-center text-xl font-semibold">No Events Available</p>
            </div>
        @endunless
    </div>

</x-app-layout>
