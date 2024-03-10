<!DOCTYPE html>
<html class="h-full overflow-x-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-application-favicon />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CineStar') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @stack('vite')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased overflow-x-hidden">
    <div class="h-full bg-gray-50 p-4">
        @if ($notification->accepted)
            <h1 class="font-bold text-lg mb-4">Subject: Reservation(s) verified</h1>
            <h2 class="font-semibold mb-6">Hello {{ Auth::user()->name }}!</h2>

            <p class="mb-4">Your <span class="font-bold">{{ $notification->ticket_numbers }}</span> reservation(s) have been verified. We look
                forward to welcoming you to the event!
            </p>

            <p class="mb-4">
                You can view your resrvations in your personal dashboard and get view your ticket.
            </p>
            <p>
                <span class="font-bold">Evento</span>
            </p>
        @else
            <h1 class="font-bold text-lg mb-4">Subject: Reservation(s) rejected</h1>
            <h2 class="font-semibold mb-6">Dear: {{ Auth::user()->name }}</h2>
            <p class="mb-4">
                We regret to inform you that <span class="font-bold">{{ $notification->ticket_numbers }}</span> of the reservation(s) you reserved got rejected for the reason(s) :
            </p>
            <p class="mb-4 font-medium">
                {{ $notification->reason }}
            </p>
            <p class="mb-4">
                We apologize once again for any inconvenience caused and thank you for your continued support. If you
                have any questions or concerns, please do not hesitate to contact us at <span
                    class="font-bold">Evento@contact.com</span>.
            </p>
            <p>
                Thank you for your understanding.
            </p>
            <p class="mb-2">
                Best regards,
            </p>
            <p>
                <span class="font-bold">Evento</span>
            </p>
        @endif
    </div>
</body>

</html>
