<x-app-layout>
    @push('vite')
        <style>
            .bg-ticket {
                background-image: url('{{ asset('assets/images/ticket-bg.png') }}');
            }
        </style>
    @endpush
    <div class="w-full flex flex-col gap-6 border-t-2 py-8 rounded-md shadow-lg p-3 h-[40vh] sm:h-[100vh]">
        <div class="relative bg-ticket bg-cover md:bg-contain md:bg-center bg-no-repeat w-full h-full text-gray-200">
            <div class="[&>*]:absolute">
                <p class="top-[10%] left-[10%] md:top-8 md:left-[10%] text-xs md:text-5xl font-bold">Evento</p>
                <p class="top-[10%] left-[30%] md:top-10 md:left-[30%] text-xs md:text-3xl w-full font-bold">
                    {{ $event->title }}</p>
                <p class="bottom-[5%] left-[10%] md:bottom-8 md:left-32 text-xs md:text-3xl">{{ $event->location }}</p>
                <p class="bottom-[10%] left-[40%] md:bottom-16 md:left-[35%] text-xs md:text-2xl">Date:</p>
                <p class="bottom-[5%] left-[40%] md:bottom-8 md:left-[35%] text-xs md:text-3xl">{{ $event->date }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
