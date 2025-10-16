<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIPANDA') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-iait.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Background halaman */
        body {
            background-image: url('{{ asset('images/Gambar.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        /* Smooth transition untuk sidebar - HANYA setelah Alpine.js load */
        .sidebar {
            transition: none;
        }

        .main-content {
            transition: none;
        }

        /* Setelah Alpine.js siap, baru tambahkan transisi */
        [x-cloak] ~ .sidebar,
        [x-cloak] ~ .main-content {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body class="font-sans antialiased"
    style="background: url('/images/Gambar5.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="h-screen bg-gray-100/40 dark:bg-gray-900/70 flex overflow-hidden main-container" 
         x-data="{ sidebarOpen: true }" 
         x-init="
             // Set initial state from localStorage
             sidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';
             
             // Setelah Alpine siap, baru aktifkan transisi
             $nextTick(() => {
                 setTimeout(() => {
                     $el.classList.add('alpine-ready');
                 }, 50);
             });
         ">

        <!-- Sidebar -->
        <aside class="sidebar w-80 bg-green-500 text-white h-screen fixed top-0 left-0 flex flex-col z-50"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            x-cloak>
            @include('layouts.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col"
            :class="sidebarOpen ? 'ml-80' : 'ml-0'"
            x-cloak>

            <!-- Top Navbar -->
            <nav
                class="bg-white/95 backdrop-blur-sm shadow px-6 py-3 flex justify-between items-center sticky top-0 z-40">
                <div class="flex items-center">
                    <!-- Tombol Toggle Sidebar -->
                    <button @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)"
                        class="mr-4 p-2 rounded-md text-gray-600 hover:text-green-600 hover:bg-green-50 transition duration-200">
                        <!-- Icon bars (garis 3) saat sidebar BUKA -->
                        <i class="fa-solid fa-bars text-xl" x-show="sidebarOpen"></i>
                        <!-- Icon bars (garis 3) saat sidebar TUTUP -->
                        <i class="fa-solid fa-bars text-xl" x-show="!sidebarOpen"></i>
                    </button>

                    <div
                        class="flex items-center text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-green-400 via-yellow-400 to-orange-500 drop-shadow-lg">
                        <i class="fas fa-leaf mr-3 animate-bounce text-green-500"></i>
                        {{ config('app.name', 'SIPANDA') }}
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Notifikasi -->
                    <button class="relative text-gray-800 hover:text-green-800">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span
                            class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1">3</span>
                    </button>

                    <!-- Setting -->
                    <button class="text-gray-800 hover:text-green-800">
                        <i class="fa-solid fa-gear text-xl"></i>
                    </button>

                    <!-- Profil Pengguna -->
                    <div class="flex items-center space-x-3">
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white" alt="Foto Profil">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white" alt="Foto Profil">
                        @endif
                        <span class="text-gray-700 font-medium">
                            {{ Auth::user()->name ?? 'Guest' }}
                        </span>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 p-4 overflow-y-auto">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <x-footer />

        </div>
    </div>

    <style>
        /* Transisi hanya aktif setelah Alpine.js ready */
        .alpine-ready .sidebar,
        .alpine-ready .main-content {
            transition: all 0.3s ease-in-out;
        }
    </style>
</body>

</html>