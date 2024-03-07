<a href="{{ route('reservation.show', [$reservation->id, $film->slug]) }}"
    {{ $attributes->merge(['class' => 'w-full bg-gray-200 shadow-lg border-t p-3 items-center rounded-lg hover:text-purple-700']) }}>
    <div class="flex flex-col gap-2">
        <div class="flex justify-between items-center text-white-50">
            <p class="text-xl">Film: {{ $film->title }}</p>
            <div class="flex items-center gap-4">
                <p>Hall: {{ $reservation->seat->hall->name }} | Seat: {{ $reservation->seat_id }}</p>
                <p>Screening Date: {{ $reservation->screening_date }}</p>
            </div>
        </div>
        {{ $slot }}
    </div>
</a>
