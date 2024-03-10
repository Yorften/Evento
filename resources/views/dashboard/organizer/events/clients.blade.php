<x-dashboard-layout>
    <x-sweet-alert />
    <div id="modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Update Film
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->

            </div>
        </div>
    </div>
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
                    <span class="mx-4 h-auto text-gray-400 font-medium">/</span>
                </li>
                <li class="inline-flex items-center">
                    <a href="{{ route('organizer.events') }}" class="hover:text-blue-500">Events</a>
                    <span class="mx-4 h-auto text-gray-400 font-medium">/</span>
                </li>
                <li class="inline-flex items-center">
                    <a href="{{ route('events.clients', $event->id) }}"
                        class="hover:text-blue-500">{{ $event->title }}</a>
                </li>
            </ul>
        </div>
        @php
            $eventsByVerification = $clients->groupBy(function ($client) {
                return $client->pivot->verified;
            });
        @endphp
        <div class="w-full flex justify-between items-center px-2 mt-4">
            <p class="text-none text-xl font-semibold indent-4">Reservations</p>
        </div>
        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
                data-tabs-toggle="#default-styled-tab-content"
                data-tabs-active-classes="text-purple-600 hover:text-purple-600 border-purple-600"
                data-tabs-inactive-classes="text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300"
                role="tablist">
                @foreach ($eventsByVerification as $verified => $clients)
                    @if ($loop->index < 2)
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="{{ 'day-' . $loop->index }}"
                                data-tabs-target="{{ '#day-' . $loop->index . '-content' }}" type="button"
                                role="tab" aria-controls="{{ 'day-' . $loop->index }}-content"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                @if ($verified == null)
                                    Pending <span>
                                        <div
                                            class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-0 dark:border-gray-900">
                                            {{ $clients->count() }}</div>
                                    </span>
                                @else
                                    Attending
                                @endif
                            </button>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
        <div id="default-styled-tab-content" class="w-full">
            @foreach ($eventsByVerification as $verified => $clients)
                @if ($loop->index < 2)
                    <div class="hidden shadow-lg border-t-2 rounded-lg w-full p-2"
                        id="{{ 'day-' . $loop->index . '-content' }}" role="tabpanel"
                        aria-labelledby="{{ 'day-' . $loop->index }}">
                        <table id="table{{ $loop->index }}" class="min-w-full divide-y divide-gray-200 stripe hover"
                            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                            <thead>
                                <tr>
                                    <th data-priority="1"
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ticket group</th>
                                    <th data-priority="1"
                                        class="px-8 py-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th data-priority="1"
                                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tickets</th>
                                    @if ($verified == null)
                                        <th data-priority="1"
                                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $clientsByGroup = $clients->groupBy(function ($client) {
                                        return $client->pivot->group;
                                    });
                                @endphp
                                @foreach ($clientsByGroup as $group => $clients)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $group }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $clients->first()->user->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ count($clients) }}
                                            </div>
                                        </td>
                                        @if ($verified == null)
                                            <td class="px-8 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('reservations.verify', $group) }}"
                                                    class="text-teal-500 hover:text-teal-700">
                                                    Verify</a>
                                                <a href="{{ route('reservations.reject', $group) }}"
                                                    class="text-red-500 hover:text-red-700">
                                                    Reject</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('#table0').DataTable({
                        responsive: true,
                        pageLength: 5,
                        lengthMenu: [
                            [5],
                            [5]
                        ]
                    })
                    .columns.adjust()
                    .responsive.recalc();
            });
            $(document).ready(function() {
                var table = $('#table1').DataTable({
                        responsive: true,
                        pageLength: 5,
                        lengthMenu: [
                            [5],
                            [5]
                        ]
                    })
                    .columns.adjust()
                    .responsive.recalc();
            });
        </script>
    @endpush
</x-dashboard-layout>
