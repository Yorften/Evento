<div id="notifications-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 right-0 left-0 z-[100] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-5xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-md">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Notifications
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="notifications-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="flex flex-col md:flex-row h-[80vh] md:h-[70vh]">
                <div
                    class="w-full h-1/3 md:h-auto md:w-1/3 flex flex-col gap-1 border-b-2 md:border-r-2 p-1 overflow-y-auto overflow-x-hidden">
                    @foreach ($notifications as $notification)
                        @if ($notification->accepted)
                            <a href="{{ route('notifications.show', $notification->id) }}" target="contentFrame"
                                class="relative w-full bg-gray-100 rounded-md shadow-sm hover:shadow-md transition-all duration-500">
                                <p class="flex items-center text-gray-800 font-bold h-12 ml-2">Resrvation(s) verified
                                </p>
                                @if ($notification->read_at == null)
                                    <div
                                        class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full top-3 end-4 dark:border-gray-900">
                                    </div>
                                @endif
                            </a>
                        @else
                            <a href="{{ route('notifications.show', $notification->id) }}" target="contentFrame"
                                class="relative w-full bg-gray-100 rounded-md shadow-sm hover:shadow-md transition-all duration-500">
                                <p class="flex items-center text-gray-800 font-bold h-12 ml-2">Resrvation(s) rejected
                                </p>
                                @if ($notification->read_at == null)
                                    <div
                                        class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-0 dark:border-gray-900">
                                    </div>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
                <div class="w-full h-full md:w-2/3">
                    <iframe id="contentFrame" name="contentFrame" src="" frameborder="0" width="100%"
                        height="100%"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
