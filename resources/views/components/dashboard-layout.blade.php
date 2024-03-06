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
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-gray-100 bg-blue-900 hover:text-white focus:outline-none transition ease-in-out duration-150">
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
                        <li>
                            <a href="{{ route('dashboard') }}"
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
                            <a href="{{ route('actor.index') }}"
                                class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        fill="#ffffff" version="1.1" id="Capa_1" class="w-5 h-5"
                                        viewBox="0 0 800 800" xml:space="preserve">
                                        <g>
                                            <path
                                                d="M290.973,331.347c0-55.45,44.987-100.406,100.499-100.406c55.534,0,100.586,44.957,100.586,100.406   c0,55.513-45.053,100.407-100.586,100.407C335.959,431.754,290.973,386.859,290.973,331.347z M800,111.167   c0,24.191-24.697,43.794-55.989,45.69V775H46.723V155.866C19.944,151.084,0,132.946,0,111.167c0-25.42,27.149-46.013,60.678-46.013   h260.588V25H486.35v40.154h252.93C772.808,65.154,800,85.748,800,111.167z M305.491,555.059   c-24.328,33.109-39.367,88.149-43.88,161.479h36.285C300.716,652.169,303.733,589.827,305.491,555.059z M488.673,716.536h30.251   c-2.258-73.286-16.516-128.11-41.472-161.436C480.664,594.479,485.895,661.646,488.673,716.536z M685.005,157.246H105.729v559.291   h84.788c6.206-111.716,33.181-187.521,82.703-231.296c10.157-9.003,20.877-17.233,32.531-24.019   c6.641-3.898,13.693-7.044,20.941-9.606c17.751-6.334,36.609-9.308,55.426-9.954l-32.509,272.505l2.321,2.37h75.935l1.996-2.37   L403.93,442.05c17.208,1.186,34.439,4.31,50.803,9.952c17.577,6.117,32.746,15.791,47.373,27.122   c55.145,42.631,84.614,122.615,87.782,237.412h95.117V157.246z" />
                                        </g>
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Actors</span>

                            </a>
                        </li>
                        <li>
                            <a href="{{ route('genre.index') }}"
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
                                <span class="ml-2 text-sm tracking-wide truncate">Genres</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('film.index') }}"
                                class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" class="w-5 h-5"
                                        viewBox="-3 0 30 30" version="1.1">

                                        <title>film</title>
                                        <desc>Created with Sketch Beta.</desc>
                                        <defs>

                                        </defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill-rule="evenodd"
                                            sketch:type="MSPage">
                                            <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                transform="translate(-260.000000, -516.000000)" fill="#ffffff">
                                                <path
                                                    d="M280,522 L282,522 L282,524 L280,524 L280,522 Z M280,526 L282,526 L282,528 L280,528 L280,526 Z M280,530 L282,530 L282,532 L280,532 L280,530 Z M280,534 L282,534 L282,536 L280,536 L280,534 Z M280,538 L282,538 L282,540 L280,540 L280,538 Z M280,542 L282,542 L282,544 L280,544 L280,542 Z M278,529 C278,529.553 277.552,530 277,530 L267,530 C266.448,530 266,529.553 266,529 L266,519 C266,518.448 266.448,518 267,518 L277,518 C277.552,518 278,518.448 278,519 L278,529 L278,529 Z M278,543 C278,543.553 277.552,544 277,544 L267,544 C266.448,544 266,543.553 266,543 L266,533 C266,532.448 266.448,532 267,532 L277,532 C277.552,532 278,532.448 278,533 L278,543 L278,543 Z M262,522 L264,522 L264,524 L262,524 L262,522 Z M262,526 L264,526 L264,528 L262,528 L262,526 Z M262,530 L264,530 L264,532 L262,532 L262,530 Z M262,534 L264,534 L264,536 L262,536 L262,534 Z M262,538 L264,538 L264,540 L262,540 L262,538 Z M262,542 L264,542 L264,544 L262,544 L262,542 Z M280,516 L264,516 C261.791,516 260,517.791 260,520 L260,546 L264,546 L280,546 L284,546 L284,520 C284,517.791 282.209,516 280,516 L280,516 Z"
                                                    id="film" sketch:type="MSShapeGroup">

                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Films</span>

                            </a>
                        </li>
                        <li>
                            <a href="{{ route('hall.index') }}"
                                class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                        id="Layer_1" data-name="Layer 1">
                                        <defs>
                                            <style>
                                                .cls-1 {
                                                    fill: none;
                                                    stroke: #ffffff;
                                                    stroke-miterlimit: 10;
                                                    stroke-width: 1.91px;
                                                }
                                            </style>
                                        </defs>
                                        <path class="cls-1"
                                            d="M9.14,1.5h5.73a2.86,2.86,0,0,1,2.86,2.86v9.55a0,0,0,0,1,0,0H6.27a0,0,0,0,1,0,0V4.36A2.86,2.86,0,0,1,9.14,1.5Z" />
                                        <path class="cls-1"
                                            d="M1.5,10.09H6.27a0,0,0,0,1,0,0v3.34a2.39,2.39,0,0,1-2.39,2.39h0A2.39,2.39,0,0,1,1.5,13.43V10.09A0,0,0,0,1,1.5,10.09Z" />
                                        <path class="cls-1"
                                            d="M17.73,10.09H22.5a0,0,0,0,1,0,0v3.34a2.39,2.39,0,0,1-2.39,2.39h0a2.39,2.39,0,0,1-2.39-2.39V10.09A0,0,0,0,1,17.73,10.09Z" />
                                        <path class="cls-1"
                                            d="M4.6,15.7h0a2.08,2.08,0,0,0-.23.95,2,2,0,0,0,2,2H17.61a2,2,0,0,0,2-2,2.08,2.08,0,0,0-.23-.95,0,0,0,0,1,0,0" />
                                        <polyline class="cls-1"
                                            points="17.79 13.98 17.73 13.91 6.27 13.91 6.21 13.98" />
                                        <line class="cls-1" x1="7.23" y1="22.5" x2="7.23"
                                            y2="18.68" />
                                        <line class="cls-1" x1="16.77" y1="22.5" x2="16.77"
                                            y2="18.68" />
                                        <line class="cls-1" x1="5.32" y1="22.5" x2="9.14"
                                            y2="22.5" />
                                        <line class="cls-1" x1="14.86" y1="22.5" x2="18.68"
                                            y2="22.5" />
                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Halls</span>

                            </a>
                        </li>
                        <li class="px-5 hidden md:block ">
                            <hr class="border-[1.2px] rounded-full">
                        </li>
                        <li>
                            <a href="{{ route('screening.index') }}"
                                class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 pr-6">
                                <span class="inline-flex justify-center items-center ml-4">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:cc="http://creativecommons.org/ns#"
                                        xmlns:dc="http://purl.org/dc/elements/1.1/"
                                        xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                        xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                        xmlns:svg="http://www.w3.org/2000/svg" viewBox="0 0 8.4666669 8.4666669"
                                        id="svg8" version="1.1">

                                        <defs id="defs2" />

                                        <g id="layer1" transform="translate(0,-288.53332)">

                                            <path
                                                d="m 16.033203,1.0117188 c -2.833585,0 -5.216959,1.9898455 -5.837891,4.640625 C 9.4641459,4.6664753 8.3021699,4.015625 6.9902344,4.015625 c -2.1972945,0 -4,1.8026961 -4,4 0,1.188193 0.5372429,2.249339 1.3691406,2.984375 H 2 c -0.5522619,5.5e-5 -0.9999448,0.447738 -1,1 v 18 c 5.52e-5,0.552262 0.4477381,0.999945 1,1 h 21 c 0.552262,-5.5e-5 0.999945,-0.447738 1,-1 v -2.998047 h 1.1875 C 25.60542,28.15831 26.707733,29 28,29 h 2 c 0.552262,-5.5e-5 0.999945,-0.447738 1,-1 V 15 c -5.5e-5,-0.552262 -0.447738,-0.999945 -1,-1 h -2 c -1.294426,0 -2.398165,0.844549 -2.814453,2.003906 H 24 V 12 c -5.5e-5,-0.552262 -0.447738,-0.999945 -1,-1 h -2.501953 c 0.951374,-1.0611695 1.537113,-2.4576012 1.537109,-3.9882812 9e-6,-3.3018709 -2.700083,-6 -6.001953,-6 z m 0,2 c 2.220988,0 4.001959,1.7790362 4.001953,4 6e-6,2.174841 -1.710876,3.9163952 -3.867187,3.9882812 h -0.269531 c -2.156157,-0.07205 -3.865241,-1.8135505 -3.865235,-3.9882812 -6e-6,-2.2209638 1.779013,-4 4,-4 z M 6.9902344,6.015625 c 1.1164142,0 2.0000004,0.8835654 2,2 4e-7,1.1163968 -0.8835858,2.001953 -2,2.001953 -1.1164143,0 -2,-0.8855562 -2,-2.001953 0,-1.1164346 0.8835857,-2 2,-2 z M 10.644531,9.6269531 C 10.889476,10.127344 11.199953,10.589077 11.568359,11 H 9.6210938 C 10.052075,10.619293 10.407924,10.158117 10.644531,9.6269531 Z M 3,13 H 22 V 29 H 3 Z m 25,3 h 1 v 11 h -1 c -0.565608,0 -0.987669,-0.421627 -0.996094,-0.984375 v -9.03125 C 27.012331,16.421591 27.434392,16 28,16 Z m -4,1.996094 h 1 v 7.005859 h -1 z"
                                                id="path827"
                                                style="color:#ffffff;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-feature-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#ffffff;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;opacity:1;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#ffffff;solid-opacity:1;vector-effect:none;fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1.99999988;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke fill markers;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate"
                                                transform="matrix(0.26458333,0,0,0.26458333,0,288.53332)" />

                                            <path
                                                d="m 1.5878906,292.50195 a 0.26465,0.26465 0 1 0 0,0.5293 h 0.5292969 a 0.26465,0.26465 0 1 0 0,-0.5293 z"
                                                id="path865"
                                                style="color:#ffffff;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-feature-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#ffffff;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;opacity:1;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#ffffff;solid-opacity:1;vector-effect:none;fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.5291667;stroke-linecap:round;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate" />

                                        </g>

                                    </svg>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Screenings</span>

                            </a>
                        </li>
                    </ul>
                    <p class="mb-14 px-5 py-3 hidden md:block text-center text-xs">Copyright @2024</p>
                </div>
            </div>
            <!-- ./Sidebar -->

            <main class="h-full ml-14 mt-14 mb-10 md:ml-64">
                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
<!-- component -->
