<div
    class="border hover:shadow-2xl shadow transition-all duration-500 flex flex-col rounded-t-lg mb-6 [&>*]:w-full w-[70vw] sm:w-[35vw] md:w-[25vw] lg:w-[20vw]">
    @if ($event->image == null)
        <img src="{{ asset('assets/images/poster.jpg') }}"
            class="h-[20vh] sm:h-[25vh] md:h-[25vh] lg:h-[25vh] object-cover inline-block rounded-t-lg" alt="">
    @else
        <img src="{{ asset('storage/' . $event->image->path) }}"
            class="h-[20vh] sm:h-[25vh] md:h-[25vh] lg:h-[25vh] object-cover inline-block rounded-t-lg" alt="">
    @endif
    <div class="[&>*]:w-full p-2 h-56 flex flex-col justify-between">
        <a href="{{ route('events.show', $event->id) }}" class="font-semibold hover:underline ">{{ $event->title }}</a>
        <p class="text-sm text-gray-600 font-medium">{{ $event->date->format('l d') }},
            {{ $event->date->format('m M') }}
            at {{ $event->date->format('H:i') }}</p>
        <p class="text-sm font-medium">{{ Str::substr($event->description, 0, 100) }}...</p>
        <div class="w-full flex items-center justify-end">
            <a href="{{ route('events.show', $event->id) }}" class=" font-semibold underline">Reserve Now </a>
            <i class='bx bx-chevron-right'></i>
        </div>
    </div>
</div>
