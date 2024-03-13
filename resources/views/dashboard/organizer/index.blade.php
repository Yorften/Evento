<x-dashboard-layout>
    <div class="w-11/12 mx-auto flex flex-col items-start justify-start mt-8 text-gray-900">
        <div class="flex items-center flex-wrap">
            <ul class="flex items-center">
                <li class="inline-flex items-center">
                    <a href="/" class="hover:text-blue-500">
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
                    <a href="{{ route('organizer.dashboard') }}" class="hover:text-blue-500">Dashboard</a>
                </li>
            </ul>
        </div>
        <div class="w-full flex justify-between items-center px-2 mt-4">
            <p class="text-none text-xl font-semibold indent-4">Stats</p>
        </div>

        <div
            class="shadow-lg border-t-2 flex flex-col md:flex-row justify-center items-center gap-4 rounded-lg w-full h-[60vh] md:[&>*]:w-2/5 [&>*]:w-full p-2 mt-8">
            <div class="mx-auto mt-4">
                <div
                    class="w-full bg-white max-w-xs mx-auto rounded-sm overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100">
                    <div class="h-20 bg-red-400 flex items-center justify-between">
                        <p class="mr-0 text-white text-lg pl-5">Total Events</p>
                    </div>
                    <div class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600">
                        <p>TOTAL</p>
                    </div>
                    <p class="py-4 text-3xl ml-5">{{ $totalEvents }}</p>
                </div>
            </div>

            <div class="mx-auto mt-4">
                <div
                    class="w-full bg-white max-w-xs mx-auto rounded-sm overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:scale-100">
                    <div class="h-20 bg-blue-500 flex items-center justify-between">
                        <p class="mr-0 text-white text-lg pl-5">Most Attended Event</p>
                    </div>
                    <div class="flex justify-between px-5 pt-6 mb-2 text-sm text-gray-600">
                        @isset($maxAttendedEvent)
                            <p>{{ $maxAttendedEvent->title }}</p>
                        @else
                            <p>No data found</p>
                        @endisset
                    </div>
                    @isset($count)
                        <p class="py-4 text-3xl ml-5">{{ $count }} reservations</p>
                    @else
                        <p></p>
                    @endisset
                </div>
            </div>

        </div>
    </div>
</x-dashboard-layout>
