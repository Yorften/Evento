<x-dashboard-layout>
    <x-sweet-alert />
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

        <div class="w-full flex justify-between items-center px-2 mt-4">
            <p class="text-none text-xl font-semibold indent-4">Reservations</p>
        </div>
        @unless (count($clients) == 0)
            @php
                $eventsByVerification = $clients->groupBy(function ($client) {
                    return $client->pivot->verified;
                });
            @endphp
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
        @else
            <p class="w-full h-[60vh] flex items-center justify-center text-xl font-bold">No reservations found</p>
        @endunless


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
