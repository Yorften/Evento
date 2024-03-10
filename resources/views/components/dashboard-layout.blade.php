<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-application-favicon />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('vite')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom style */
        .header-right {
            width: calc(100% - 3.5rem);
        }

        .sidebar:hover {
            width: 16rem;
        }

        table.dataTable th.dt-type-numeric,
        table.dataTable th.dt-type-date,
        table.dataTable td.dt-type-numeric,
        table.dataTable td.dt-type-date {
            text-align: left;
        }

        @media only screen and (min-width: 768px) {
            .header-right {
                width: calc(100% - 16rem);
            }
        }
    </style>
</head>

<body>
    <div>
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white text-black">

            <!-- Header -->
            <div class="fixed bg-blue-800 w-full flex items-center justify-between h-14 text-white px-4 z-10">
                <a href="{{ route('welcome') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-white" />
                </a>
                <div class="flex justify-end items-center h-14 bg-blue-800 header-right">
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="relative inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-gray-100 bg-blue-900 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                    @isset($notifications)
                                        @if ($count = $notifications->where('read_at', null)->count())
                                            <div
                                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-0 dark:border-gray-900">
                                                {{ $count }}</div>
                                        @endif
                                    @endisset
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                @hasrole('admin')
                                    <x-dropdown-link :href="route('admin.dashboard')">
                                        {{ __('Reservations') }}
                                    </x-dropdown-link>
                                @endhasrole
                                @hasrole('client')
                                    <x-dropdown-link :href="route('reservations.index')">
                                        {{ __('Reservations') }}
                                    </x-dropdown-link>
                                    <x-dropdown-button data-modal-toggle="notifications-modal"
                                        data-modal-target="notifications-modal" :count="$notifications->where('read_at', null)->count()">
                                        {{ __('Notifications') }}
                                    </x-dropdown-button>
                                @endhasrole
                                @hasrole('organizer')
                                    <x-dropdown-link :href="route('organizer.dashboard')">
                                        {{ __('Dashboard') }}
                                    </x-dropdown-link>
                                    <x-dropdown-button data-modal-toggle="notifications-modal"
                                        data-modal-target="notifications-modal" :count="$org_notifications->where('read_at', null)->count()">
                                        {{ __('Notifications') }}
                                    </x-dropdown-button>
                                @endhasrole

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
            <!-- ./Header -->

            <!-- Sidebar -->
            <div
                class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-blue-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
                <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
                    <ul class="flex flex-col py-4 space-y-1">
                        <li class="px-5 hidden md:block">
                            <div class="flex flex-row items-center h-8">
                                <div class="text-sm font-light tracking-wide text-white uppercase"></div>
                            </div>
                        </li>
                        @hasrole('admin')
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                                </a>
                            </li>
                            <li class="px-5 hidden md:block ">
                                <hr class="border-[1.2px] rounded-full">
                            </li>

                            <li>
                                <a href="{{ route('categories.index') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:serif="http://www.serif.com/" fill="#ffffff" class="w-5 h-5"
                                            viewBox="0 0 64 64" version="1.1" xml:space="preserve"
                                            style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">

                                            <rect id="Icons" x="-384" y="-320" width="1280" height="800"
                                                style="fill:none;" />

                                            <g id="Icons1" serif:id="Icons">

                                                <g id="Strike">

                                                </g>

                                                <g id="H1">

                                                </g>

                                                <g id="H2">

                                                </g>

                                                <g id="H3">

                                                </g>

                                                <g id="list-ul">

                                                </g>

                                                <g id="hamburger-1">

                                                </g>

                                                <g id="hamburger-2">

                                                </g>

                                                <g id="list-ol">

                                                </g>

                                                <g id="list-task">

                                                </g>

                                                <g id="trash">

                                                </g>

                                                <g id="vertical-menu">

                                                </g>

                                                <g id="horizontal-menu">

                                                </g>

                                                <g id="sidebar-2">

                                                </g>

                                                <g id="Pen">

                                                </g>

                                                <g id="Pen1" serif:id="Pen">

                                                </g>

                                                <g id="clock">

                                                </g>

                                                <g id="external-link">

                                                </g>

                                                <g id="hr">

                                                </g>

                                                <g id="info">

                                                </g>

                                                <g id="warning">

                                                </g>

                                                <g id="plus-circle">

                                                </g>

                                                <g id="minus-circle">

                                                </g>

                                                <g id="vue">

                                                </g>

                                                <g id="cog">

                                                </g>

                                                <g id="logo">

                                                </g>

                                                <g id="radio-check">

                                                </g>

                                                <g id="eye-slash">

                                                </g>

                                                <g id="eye">

                                                </g>

                                                <g id="toggle-off">

                                                </g>

                                                <g id="shredder">

                                                </g>

                                                <g>

                                                    <path
                                                        d="M9.89,30.496c-1.14,1.122 -1.784,2.653 -1.791,4.252c-0.006,1.599 0.627,3.135 1.758,4.266c3.028,3.028 7.071,7.071 10.081,10.082c2.327,2.326 6.093,2.349 8.448,0.051c5.91,-5.768 16.235,-15.846 19.334,-18.871c0.578,-0.564 0.905,-1.338 0.905,-2.146c0,-4.228 0,-17.607 0,-17.607l-17.22,0c-0.788,0 -1.544,0.309 -2.105,0.862c-3.065,3.018 -13.447,13.239 -19.41,19.111Zm34.735,-15.973l0,11.945c0,0.811 -0.329,1.587 -0.91,2.152c-3.069,2.981 -13.093,12.718 -17.485,16.984c-1.161,1.127 -3.012,1.114 -4.157,-0.031c-2.387,-2.386 -6.296,-6.296 -8.709,-8.709c-0.562,-0.562 -0.876,-1.325 -0.872,-2.12c0.003,-0.795 0.324,-1.555 0.892,-2.112c4.455,-4.373 14.545,-14.278 17.573,-17.25c0.561,-0.551 1.316,-0.859 2.102,-0.859c3.202,0 11.566,0 11.566,0Zm-7.907,2.462c-1.751,0.015 -3.45,1.017 -4.266,2.553c-0.708,1.331 -0.75,2.987 -0.118,4.356c0.836,1.812 2.851,3.021 4.882,2.809c2.042,-0.212 3.899,-1.835 4.304,-3.896c0.296,-1.503 -0.162,-3.136 -1.213,-4.251c-0.899,-0.953 -2.18,-1.548 -3.495,-1.57c-0.031,-0.001 -0.062,-0.001 -0.094,-0.001Zm0.008,2.519c1.105,0.007 2.142,0.849 2.343,1.961c0.069,0.384 0.043,0.786 -0.09,1.154c-0.393,1.079 -1.62,1.811 -2.764,1.536c-1.139,-0.274 -1.997,-1.489 -1.802,-2.67c0.177,-1.069 1.146,-1.963 2.27,-1.981c0.014,0 0.029,0 0.043,0Z" />

                                                    <path
                                                        d="M48.625,13.137l0,4.001l3.362,0l0,11.945c0,0.811 -0.328,1.587 -0.909,2.152c-3.069,2.981 -13.093,12.717 -17.485,16.983c-1.161,1.128 -3.013,1.114 -4.157,-0.03l-0.034,-0.034l-1.016,0.993c-0.663,0.646 -1.437,1.109 -2.259,1.389l1.174,1.174c2.327,2.327 6.093,2.35 8.447,0.051c5.91,-5.768 16.235,-15.845 19.335,-18.87c0.578,-0.565 0.904,-1.339 0.904,-2.147c0,-4.227 0,-17.607 0,-17.607l-7.362,0Z" />

                                                </g>

                                                <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]">

                                                </g>

                                                <g id="react">

                                                </g>

                                                <g id="check-selected">

                                                </g>

                                                <g id="turn-off">

                                                </g>

                                                <g id="code-block">

                                                </g>

                                                <g id="user">

                                                </g>

                                                <g id="coffee-bean">

                                                </g>

                                                <g id="coffee-beans">

                                                    <g id="coffee-bean1" serif:id="coffee-bean">

                                                    </g>

                                                </g>

                                                <g id="coffee-bean-filled">

                                                </g>

                                                <g id="coffee-beans-filled">

                                                    <g id="coffee-bean2" serif:id="coffee-bean">

                                                    </g>

                                                </g>

                                                <g id="clipboard">

                                                </g>

                                                <g id="clipboard-paste">

                                                </g>

                                                <g id="clipboard-copy">

                                                </g>

                                                <g id="Layer1">

                                                </g>

                                            </g>

                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Categories</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.events') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            fill="#ffffff" class="w-5 h-5" version="1.1" id="Layer_1"
                                            viewBox="0 0 24 24" xml:space="preserve">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: none;
                                                }
                                            </style>
                                            <g>
                                                <path
                                                    d="M20,7.4v10.5c0,1.7-1.3,3-3,3H5.9c0,1.1,0.9,2,2,2H18c2.2,0,4-1.8,4-4V9.4C22,8.3,21.1,7.4,20,7.4z" />
                                                <g>
                                                    <path
                                                        d="M5,1.1v2H4c-1.1,0-2,0.9-2,2v12c0,1.1,0.9,2,2,2h12.2c1.1,0,2-0.9,2-2v-12c0-1.1-0.9-2-2-2h-1v-2h-2v2H7v-2    C7,1.1,5,1.1,5,1.1z M4,8.1h12.2v9H4V8.1z" />
                                                    <path
                                                        d="M13.7,16.3l-2.4-1.4L9,16.3l0.6-2.7l-2.1-1.8l2.8-0.2L11.4,9l1.1,2.5l2.8,0.3l-2.1,1.8L13.7,16.3z" />
                                                </g>
                                            </g>
                                            <rect class="st0" width="24" height="24" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Events</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('organizers.index') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            fill="#ffffff" width="800px" height="800px" viewBox="0 0 512 512"
                                            enable-background="new 0 0 512 512" class="w-5 h-5" id="Teamwork"
                                            version="1.1" xml:space="preserve">

                                            <g>

                                                <circle cx="377.172" cy="164.224" r="37.081" />

                                                <path
                                                    d="M174.829,491.418l14.338-107.463l-4.645-34.808l1.414-1.28l-26.719-24.368l-0.225-0.224   c-17.494-17.521-19.881-44.519-7.158-64.61l-0.721-1.063l7.842-7.953l20.902-20.902c1.477-1.479,2.988-2.528,4.514-3.786   c-11.586-6.324-24.668-9.461-38.1-9.461h-21.398c-21.104,0-41.354,7.223-56.271,22.139L47.7,257.5h0.043   c-15.029,16-15.029,40.289,0,55.344l38.881,35.893L67.409,492.919c-0.383,2.881,1.867,5.581,4.77,5.581h29.363   c2.408,0,4.432-1.674,4.77-4.059l15.908-115.395c0.268-1.957,0.924-3.755,1.869-5.374c5.016-8.553,17.953-8.538,22.947,0.013   c0.969,1.619,1.621,3.448,1.889,5.407l15.91,115.347c0.338,2.387,2.361,4.061,4.77,4.061h5.711   C174.69,496.5,174.511,493.824,174.829,491.418z M93.173,304.668l-12.285-12.307c-3.285-3.285-3.285-8.596,0-11.881l15.545-15.545   c0.811-0.813,2.184-0.137,2.027,1.01L93.173,304.668z" />

                                                <circle cx="135.571" cy="164.225" r="37.081" />

                                                <path
                                                    d="M211.427,64.974l5.396,1.191c0.971,0.213,1.704,0.971,1.919,1.939c0.834,3.764,2.206,7.322,4.049,10.584   c0.465,0.82,0.434,1.828-0.074,2.625l-3.352,5.225c-0.646,1.008-0.505,2.328,0.343,3.174l5.258,5.264   c0.85,0.846,2.167,0.988,3.175,0.344l4.749-3.041c0.838-0.537,1.913-0.531,2.75,0.008c3.148,2.014,6.607,3.588,10.289,4.627   c0.902,0.256,1.592,0.984,1.793,1.9l1.334,6.39c0.258,1.164,1.291,2.296,2.488,2.296h7.441c1.197,0,2.232-1.132,2.486-2.296   l1.201-5.613c0.213-0.975,0.977-1.806,1.955-2.017c3.775-0.813,7.346-2.212,10.621-4.039c0.82-0.457,1.822-0.447,2.611,0.059   l5.178,3.306c1.01,0.646,2.33,0.5,3.176-0.348l5.262-5.263c0.846-0.846,0.988-2.167,0.346-3.178l-2.949-4.602   c-0.539-0.844-0.529-1.921,0.016-2.761c2.076-3.195,3.691-6.719,4.754-10.477c0.256-0.9,0.984-1.588,1.902-1.787l5.907-1.287   c1.168-0.254,2.047-1.291,2.047-2.486v-7.441c0-1.195-0.879-2.23-2.047-2.488l-5.222-1.141c-0.98-0.215-1.749-0.982-1.956-1.961   c-0.822-3.879-2.228-7.541-4.118-10.895c-0.461-0.82-0.438-1.826,0.068-2.619l3.17-4.951c0.645-1.006,0.501-2.328-0.347-3.172   l-5.262-5.264c-0.846-0.846-2.164-0.99-3.172-0.344l-4.427,2.834c-0.842,0.539-1.918,0.531-2.758-0.014   c-3.254-2.105-6.844-3.734-10.674-4.791c-0.908-0.252-1.602-0.982-1.807-1.904l-1.25-5.883c-0.258-1.168-1.293-2.177-2.488-2.177   h-7.441c-1.197,0-2.232,1.009-2.486,2.177l-1.135,5.26c-0.213,0.973-0.975,1.769-1.949,1.981c-3.865,0.842-7.518,2.284-10.854,4.19   c-0.822,0.467-1.836,0.455-2.631-0.055l-4.998-3.198c-1.01-0.643-2.33-0.499-3.176,0.349l-5.262,5.262   c-0.848,0.846-0.99,2.167-0.344,3.174l2.928,4.573c0.535,0.838,0.531,1.907-0.002,2.745c-2.049,3.205-3.635,6.732-4.668,10.488   c-0.25,0.908-0.984,1.605-1.904,1.809l-5.863,1.303c-1.17,0.254-1.927,1.289-1.927,2.486v7.441   C209.5,63.681,210.257,64.716,211.427,64.974z M256.378,37.8c12.193,0,22.076,9.885,22.076,22.076   c0,12.193-9.883,22.076-22.076,22.076c-12.191,0-22.074-9.883-22.074-22.076C234.304,47.685,244.187,37.8,256.378,37.8z" />

                                                <path
                                                    d="M135.167,106.572c0.287,0.041,0.57,0.059,0.852,0.059c3.041,0,5.695-2.246,6.121-5.344   c2.762-20.082,20.154-35.223,40.459-35.223c3.416,0,6.188-2.771,6.188-6.188s-2.771-6.188-6.188-6.188   c-26.455,0-49.119,19.738-52.719,45.91C129.413,102.984,131.782,106.107,135.167,106.572z" />

                                                <path
                                                    d="M327.524,66.064c20.35,0,37.748,15.182,40.469,35.311c0.42,3.107,3.076,5.359,6.123,5.359c0.277,0,0.557-0.018,0.838-0.057   c3.387-0.459,5.762-3.574,5.305-6.961c-3.549-26.238-26.219-46.027-52.734-46.027c-3.418,0-6.188,2.771-6.188,6.188   S324.106,66.064,327.524,66.064z" />

                                                <path
                                                    d="M316.776,435.057l-11.451-85.861l11.475-10.461l27.404-24.998c15.031-15.051,15.031-39.443,0-54.473l0.045-0.068   l-20.902-20.903c-2.092-2.092-4.297-3.815-6.592-5.59c-14.041-11.271-31.545-17.202-49.68-17.202h-21.4   c-18.133,0-35.639,5.931-49.68,17.181c-2.293,1.797-4.5,3.649-6.592,5.741l-20.902,20.837l0.047,0.037   c-15.029,15.029-15.029,39.404,0,54.457l27.404,24.987l11.473,10.458l-11.451,85.86l-7.76,58.206   c-0.361,2.721,1.619,5.06,4.273,5.331c0.158,0.021,0.338-0.096,0.494-0.096h29.363c2.406,0,4.432-1.664,4.768-4.047l15.91-115.389   c0.27-1.957,0.922-3.774,1.867-5.394c5.018-8.527,17.955-8.515,22.949,0.013c0.967,1.619,1.621,3.472,1.891,5.433l15.908,115.333   c0.336,2.385,2.361,4.051,4.77,4.051h29.363c0.154,0,0.336,0.115,0.494,0.094c2.654-0.273,4.637-2.666,4.275-5.389L316.776,435.057   z M213.974,304.691l-12.285-12.309c-3.285-3.285-3.285-8.594,0-11.879l15.549-15.547c0.811-0.811,2.182-0.137,2.025,0.988   L213.974,304.691z M293.487,265.945c-0.154-1.125,1.217-1.799,2.027-0.988l15.547,15.547c3.285,3.285,3.285,8.594,0,11.879   l-12.285,12.309L293.487,265.945z" />

                                                <path
                                                    d="M465.007,259.242l0.043-0.068l-20.898-20.634c-14.941-14.916-35.17-23.04-56.275-23.04h-21.396   c-13.445,0-26.539,3.142-38.131,9.485c1.525,1.291,3.045,2.522,4.543,4.02l28.791,28.66l-0.766,1.063   c12.723,20.096,10.336,47.057-7.162,64.58l-0.453,0.417L326.81,347.88l1.42,1.296l-4.643,34.823l14.334,107.38   c0.32,2.432,0.141,5.121-0.494,7.121h5.721c2.406,0,4.432-1.674,4.77-4.059l15.908-115.395c0.27-1.957,0.92-3.755,1.867-5.374   c5.018-8.553,17.955-8.538,22.949,0.013c0.947,1.619,1.596,3.448,1.891,5.407l15.906,115.347c0.338,2.387,2.361,4.061,4.771,4.061   h29.361c2.902,0,5.152-2.482,4.77-5.365l-19.215-144.012l38.881-35.437C480.036,298.634,480.036,274.271,465.007,259.242z    M431.862,292.361l-12.283,12.307l-5.287-38.723c-0.158-1.146,1.215-1.822,2.025-1.01l15.545,15.545   C435.151,283.766,435.151,289.076,431.862,292.361z" />

                                                <path
                                                    d="M256.376,126.5h-0.002c-20.479,0-37.078,16.519-37.078,36.999c0,20.479,16.6,37.001,37.078,37.001h0.002   c20.479,0,37.08-16.522,37.08-37.001C293.456,143.019,276.854,126.5,256.376,126.5z" />

                                            </g>

                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Organizers</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('clients.index') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px"
                                            viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                            <circle cx="12" cy="6" r="4" stroke="#ffffff"
                                                stroke-width="1.5" />
                                            <path
                                                d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z"
                                                stroke="#ffffff" stroke-width="1.5" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Clients</span>
                                </a>
                            </li>
                        @endhasrole
                        @hasrole('organizer')
                            <li>
                                <a href="{{ route('organizer.dashboard') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                                </a>
                            </li>
                            <li class="px-5 hidden md:block ">
                                <hr class="border-[1.2px] rounded-full">
                            </li>


                            <li>
                                <a href="{{ route('events.pending') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" width="800px"
                                            height="800px" viewBox="0 0 32 32" class="w-5 h-5" id="icon">
                                            <defs>
                                                <style>
                                                    .cls-1 {
                                                        fill: none;
                                                    }
                                                </style>
                                            </defs>
                                            <circle cx="9" cy="16" r="2" />
                                            <circle cx="23" cy="16" r="2" />
                                            <circle cx="16" cy="16" r="2" />
                                            <path
                                                d="M16,30A14,14,0,1,1,30,16,14.0158,14.0158,0,0,1,16,30ZM16,4A12,12,0,1,0,28,16,12.0137,12.0137,0,0,0,16,4Z"
                                                transform="translate(0 0)" />
                                            <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;"
                                                class="cls-1" width="32" height="32" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Pending Events</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('events.rejected') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            fill="#ffffff" width="800px" height="800px" viewBox="0 0 24 24"
                                            id="Layer_1" version="1.1" class="w-5 h-5" xml:space="preserve">
                                            <path
                                                d="M18,18c-0.55,0-1,0.45-1,1v1H6V4h6v5c0,0.55,0.45,1,1,1h4v1c0,0.55,0.45,1,1,1s1-0.45,1-1V9c0-0.13-0.03-0.25-0.07-0.37  c-0.02-0.04-0.04-0.08-0.07-0.11c-0.03-0.05-0.05-0.11-0.09-0.16l-5-6c-0.01-0.01-0.02-0.02-0.03-0.03  c-0.07-0.07-0.15-0.13-0.23-0.18c-0.03-0.02-0.06-0.05-0.1-0.06C13.28,2.03,13.15,2,13,2H5C4.45,2,4,2.45,4,3v18c0,0.55,0.45,1,1,1  h13c0.55,0,1-0.45,1-1v-2C19,18.45,18.55,18,18,18z M14,5.76L15.86,8H14V5.76z" />
                                            <path
                                                d="M8,10h2c0.55,0,1-0.45,1-1s-0.45-1-1-1H8C7.45,8,7,8.45,7,9S7.45,10,8,10z" />
                                            <path
                                                d="M13,11H8c-0.55,0-1,0.45-1,1s0.45,1,1,1h5c0.55,0,1-0.45,1-1S13.55,11,13,11z" />
                                            <path
                                                d="M13,14H8c-0.55,0-1,0.45-1,1s0.45,1,1,1h5c0.55,0,1-0.45,1-1S13.55,14,13,14z" />
                                            <path
                                                d="M13,17H8c-0.55,0-1,0.45-1,1s0.45,1,1,1h5c0.55,0,1-0.45,1-1S13.55,17,13,17z" />
                                            <path
                                                d="M20.71,12.29c-0.39-0.39-1.02-0.39-1.41,0L18,13.59l-1.29-1.29c-0.39-0.39-1.02-0.39-1.41,0s-0.39,1.02,0,1.41L16.59,15  l-1.29,1.29c-0.39,0.39-0.39,1.02,0,1.41s1.02,0.39,1.41,0L18,16.41l1.29,1.29C19.49,17.9,19.74,18,20,18s0.51-0.1,0.71-0.29  c0.39-0.39,0.39-1.02,0-1.41L19.41,15l1.29-1.29C21.1,13.32,21.1,12.68,20.71,12.29z" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Rejected Events</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('organizer.events') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            fill="#ffffff" class="w-5 h-5" version="1.1" id="Layer_1"
                                            viewBox="0 0 24 24" xml:space="preserve">
                                            <style type="text/css">
                                                .st0 {
                                                    fill: none;
                                                }
                                            </style>
                                            <g>
                                                <path
                                                    d="M20,7.4v10.5c0,1.7-1.3,3-3,3H5.9c0,1.1,0.9,2,2,2H18c2.2,0,4-1.8,4-4V9.4C22,8.3,21.1,7.4,20,7.4z" />
                                                <g>
                                                    <path
                                                        d="M5,1.1v2H4c-1.1,0-2,0.9-2,2v12c0,1.1,0.9,2,2,2h12.2c1.1,0,2-0.9,2-2v-12c0-1.1-0.9-2-2-2h-1v-2h-2v2H7v-2    C7,1.1,5,1.1,5,1.1z M4,8.1h12.2v9H4V8.1z" />
                                                    <path
                                                        d="M13.7,16.3l-2.4-1.4L9,16.3l0.6-2.7l-2.1-1.8l2.8-0.2L11.4,9l1.1,2.5l2.8,0.3l-2.1,1.8L13.7,16.3z" />
                                                </g>
                                            </g>
                                            <rect class="st0" width="24" height="24" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Events</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('events.history') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px"
                                            viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.01112 11.5747L6.29288 10.2929C6.68341 9.90236 7.31657 9.90236 7.7071 10.2929C8.09762 10.6834 8.09762 11.3166 7.7071 11.7071L4.7071 14.7071C4.51956 14.8946 4.26521 15 3.99999 15C3.73477 15 3.48042 14.8946 3.29288 14.7071L0.292884 11.7071C-0.0976406 11.3166 -0.0976406 10.6834 0.292884 10.2929C0.683408 9.90236 1.31657 9.90236 1.7071 10.2929L3.0081 11.5939C3.22117 6.25933 7.61317 2 13 2C18.5229 2 23 6.47715 23 12C23 17.5228 18.5229 22 13 22C9.85817 22 7.05429 20.5499 5.22263 18.2864C4.87522 17.8571 4.94163 17.2274 5.37096 16.88C5.80028 16.5326 6.42996 16.599 6.77737 17.0283C8.24562 18.8427 10.4873 20 13 20C17.4183 20 21 16.4183 21 12C21 7.58172 17.4183 4 13 4C8.72441 4 5.23221 7.35412 5.01112 11.5747ZM13 5C13.5523 5 14 5.44772 14 6V11.5858L16.7071 14.2929C17.0976 14.6834 17.0976 15.3166 16.7071 15.7071C16.3166 16.0976 15.6834 16.0976 15.2929 15.7071L12.2929 12.7071C12.1054 12.5196 12 12.2652 12 12V6C12 5.44772 12.4477 5 13 5Z"
                                                fill="#ffffff" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Events History</span>
                                </a>
                            </li>
                        @endhasrole
                        @hasrole('client')
                            <li>
                                <a href="{{ route('reservations.index') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="800px"
                                            height="800px" viewBox="0 0 24 24" fill="none">
                                            <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 16H8a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h9m0 11h3a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1h-3m0 11v-1m0-10v1" />
                                            <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 20H4a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h3m6 11h3a1 1 0 0 0 1-1v-2.5M13 20v-1m4-9.999V9m0 3.001V12" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Reservations</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reservations.pending') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" width="800px"
                                            height="800px" viewBox="0 0 32 32" class="w-5 h-5" id="icon">
                                            <defs>
                                                <style>
                                                    .cls-1 {
                                                        fill: none;
                                                    }
                                                </style>
                                            </defs>
                                            <circle cx="9" cy="16" r="2" />
                                            <circle cx="23" cy="16" r="2" />
                                            <circle cx="16" cy="16" r="2" />
                                            <path
                                                d="M16,30A14,14,0,1,1,30,16,14.0158,14.0158,0,0,1,16,30ZM16,4A12,12,0,1,0,28,16,12.0137,12.0137,0,0,0,16,4Z"
                                                transform="translate(0 0)" />
                                            <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;"
                                                class="cls-1" width="32" height="32" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Pending Reservations</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reservations.history') }}"
                                    class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                    <span class="inline-flex justify-center items-center ml-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px"
                                            viewBox="0 0 24 24" class="w-5 h-5" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.01112 11.5747L6.29288 10.2929C6.68341 9.90236 7.31657 9.90236 7.7071 10.2929C8.09762 10.6834 8.09762 11.3166 7.7071 11.7071L4.7071 14.7071C4.51956 14.8946 4.26521 15 3.99999 15C3.73477 15 3.48042 14.8946 3.29288 14.7071L0.292884 11.7071C-0.0976406 11.3166 -0.0976406 10.6834 0.292884 10.2929C0.683408 9.90236 1.31657 9.90236 1.7071 10.2929L3.0081 11.5939C3.22117 6.25933 7.61317 2 13 2C18.5229 2 23 6.47715 23 12C23 17.5228 18.5229 22 13 22C9.85817 22 7.05429 20.5499 5.22263 18.2864C4.87522 17.8571 4.94163 17.2274 5.37096 16.88C5.80028 16.5326 6.42996 16.599 6.77737 17.0283C8.24562 18.8427 10.4873 20 13 20C17.4183 20 21 16.4183 21 12C21 7.58172 17.4183 4 13 4C8.72441 4 5.23221 7.35412 5.01112 11.5747ZM13 5C13.5523 5 14 5.44772 14 6V11.5858L16.7071 14.2929C17.0976 14.6834 17.0976 15.3166 16.7071 15.7071C16.3166 16.0976 15.6834 16.0976 15.2929 15.7071L12.2929 12.7071C12.1054 12.5196 12 12.2652 12 12V6C12 5.44772 12.4477 5 13 5Z"
                                                fill="#ffffff" />
                                        </svg>
                                    </span>
                                    <span class="ml-2 text-sm tracking-wide truncate">Reservations History</span>
                                </a>
                            </li>
                        @endhasrole


                        <li class="px-5 hidden md:block ">
                            <hr class="border-[1.2px] rounded-full">
                        </li>

                    </ul>
                    <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">Copyright @2024</p>
                </div>
            </div>
            <!-- ./Sidebar -->
            @isset($notifications)
                <x-notifications-modal :notifications="$notifications" />
            @endisset
            @isset($org_notifications)
                <x-notifications-modal :notifications="$org_notifications" />
            @endisset
            <main class="h-full ml-14 mt-14 mb-10 md:ml-64">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
<!-- component -->
