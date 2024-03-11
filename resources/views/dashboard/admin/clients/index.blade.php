<x-dashboard-layout>
    @push('vite')
        @vite('resources/js/client_edit_modal.js')
    @endpush
    <x-sweet-alert />
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Ban Reason
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="post" action="{{ route('bans.store', 3) }}" id="edit_form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-6 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900">Reason</label>
                            <input type="text" name="reason" id="edit_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Reason" required="">
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex justify-center items-center bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full">
                        <p>Ban</p>
                    </button>
                </form>
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
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-500">Dashboard</a>
                    <span class="mx-4 h-auto text-gray-400 font-medium">/</span>
                </li>
                <li class="inline-flex items-center">
                    <a href="{{ route('clients.index') }}" class="hover:text-blue-500">Clients</a>
                </li>
            </ul>
        </div>
        <div class="w-full flex justify-between items-center px-2 mt-4">
            <p class="text-none text-xl font-semibold indent-4">All Clients</p>
        </div>

        <div class="shadow-lg border-t-2 rounded-lg w-full p-2 mt-8">
            <table id="table" class="min-w-full divide-y divide-gray-200 stripe hover"
                style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th data-priority="1"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Id</th>
                        <th data-priority="1"
                            class="px-8 py-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name</th>
                        <th data-priority="1"
                            class="px-8 py-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Country</th>
                        <th data-priority="1"
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($clients as $client)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $client->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $client->user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $client->country }}
                                </div>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-red-500 hover:text-red-700"
                                    onclick="openEditModal({{ $client->user->id }})">
                                    Ban</button>
                                <form action="{{ route('bans.destroy', $client->user->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-green-500 hover:text-green-700 ml-4">Unban</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('#table').DataTable({
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
