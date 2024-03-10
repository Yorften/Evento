<div {{ $attributes->merge(['class' => 'flex items-center gap-4 h-[10vh]']) }}>
    <div class="hidden md:block text-center w-24 shadow">
        <p class="block bg-fuchsia-700 p-2 rounded-tr rounded-tl text-gray-200 font-semibold">
            {{ $event->date->format('M') }}</p>
        <p class="block p-4 border font-bold">{{ $event->date->format('m') }}</p>
    </div>
    <div class="flex flex-col h-full justify-between">
        <p class="text-xl font-semibold">{{ $event->title }} - {{ $event->location }},
            {{ $event->date->format('l d') }},
            {{ $event->date->format('m M') }}, {{ $event->date->format('Y ') }}
            at {{ $event->date->format('H:i') }} </p>
        <p class="text-sm text-gray-700">{{ $event->location }} • Starts on
            {{ $event->date->format('l d') }}, {{ $event->date->format('m M') }},
            {{ $event->date->format('Y ') }}
            at {{ $event->date->format('H:i') }}
        </p>
    </div>
</div>
