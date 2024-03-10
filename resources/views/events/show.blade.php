@php
    $places = $event->capacity - ($event->clients ? $event->clients()->wherePivot('verified', true)->count() : 0);
@endphp
<x-app-layout>
    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900
                    Static modal">
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 text-center">
                    <p class="text-base leading-relaxed text-gray-500">
                        Phone: {{ $event->organizer->phone }}
                    </p>
                    <p class="text-base leading-relaxed text-gray-500">
                        Email: {{ $event->organizer->company_email }}
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-center items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button data-modal-hide="default-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-bold text-gray-200 focus:outline-none bg-fuchsia-700 rounded-lg border border-gray-200 hover:bg-fuchsia-800 focus:z-10 focus:ring-4 focus:ring-fuchsia-200 ">Cancel</button>
                </div>
            </div>
        </div>
    </div>
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
                    <span class="mx-4 h-auto text-gray-400 font-medium">/</span>
                </li>
                <li class="inline-flex items-center">
                    <a href="{{ route('events.show', $event->id) }}" class="hover:text-fuchsia-700">{{ $event->title }}-
                        {{ $event->location }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div
        class="w-[95%] md:w-[90%] lg:w-[80%] min-h-[85vh] mx-auto flex flex-col items-start justify-start mt-12 mb-20 gap-8 text-gray-900">
        <x-event-title :event="$event" class="mb-8" />
        <div class="flex flex-col md:flex-row gap-4 w-full">
            <div class="flex flex-col items-center w-full md:w-[70%] gap-4">
                @if ($event->image == null)
                    <img src="{{ asset('assets/images/poster.jpg') }}"
                        class="w-full h-[25vh] md:w-[90vw] md:h-[60vh] object-cover inline-block rounded-lg"
                        alt="">
                @else
                    <img src="{{ asset('storage/' . $event->image->path) }}"
                        class="w-full h-[25vh] md:w-[90vw] md:h-[60vh] object-cover inline-block rounded-lg"
                        alt="">
                @endif
                <div class="p-4 border-2 border-gray-300 rounded-md shadow-sm">
                    <p class="text-lg font-medium my-4">About this event</p>
                    <p class="text-lg font-normal text-left">{{ $event->description }}</p>
                </div>
            </div>
            <div
                class="flex flex-col items-center w-full md:w-[30%] gap-4 border-2 bg-gray-50 border-gray-300 rounded-md shadow-md">
                <p class="w-full flex items-center text-lg font-medium h-14 p-4 border-b-2 border-gray-300">Event
                    Details</p>
                <div class="w-full text-center p-2">
                    <p id="demo" class="text-gray-700 font-medium text-3xl"></p>
                </div>
                <p class="w-full flex items-center text-lg font-medium h-14 p-4 border-b-2 border-gray-300">Reserve your
                    tickets</p>
                <form id="event_form" action="{{ route('reservations.store') }}" method="POST"
                    class="flex flex-col items-center w-full">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="flex px-2 w-full items-center justify-between mt-6">
                        <p class="font-medium text-gray-600">Places left: {{ $places }}</p>

                    </div>
                    <div class="flex px-2 w-full items-center justify-between my-6">
                        <p class="font-medium text-gray-600">Normal - 250 MAD</p>
                        <x-ticket-counter :max="$places" />
                    </div>
                    <div class="w-11/12">
                        <p class=" border-b-[1.5px] border-gray-300 my-4"></p>
                        <p class=" text-sm text-gray-700"><span id="number">0</span> ticket(s)</p>
                        <p class=" text-lg font-semibold">Total: <span id="price">0</span> MAD</p>
                    </div>
                    <x-primary-button class="w-11/12 h-12 text-center my-8">
                        {{ __('Reserve now!') }}
                    </x-primary-button>
                </form>
                <div class="flex flex-col items-center w-11/12 my-8">
                    <p class="text-gray-700 font-medium">Organised by: {{ $event->organizer->user->name }}</p>
                    <a data-modal-toggle="default-modal" data-modal-target="default-modal"
                        class="cursor-pointer hover:underline text-gray-600">Contact</a>
                    <p class="text-gray-700 font-medium mt-8">Date and time:</p>
                    <p>{{ $event->date->format('l d') }}, {{ $event->date->format('m M') }},
                        {{ $event->date->format('Y ') }}
                        at {{ $event->date->format('H:i') }}</p>

                </div>
            </div>
        </div>
    </div>
    @push('vite')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            .bg-header {
                background-image: url('{{ asset('assets/images/bg-header.jpg') }}');
            }
        </style>
    @endpush
    @push('scripts')
        <script src="{{ asset('js/max_reached.js') }}"></script>
        <script>
            var countDownDate = new Date("{{ $event->date }}").getTime();

            var x = setInterval(function() {

                var now = new Date().getTime();

                var distance = countDownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                    minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                }
            }, 1000);
        </script>
    @endpush
</x-app-layout>
