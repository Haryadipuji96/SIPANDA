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
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Sidebar sebagai modal fixed */
        .sidebar-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: #16A34A;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Kontainer scroll untuk sidebar - PERBAIKAN */
        .sidebar-scroll-container {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll-container {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .sidebar-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll-container::-webkit-scrollbar-track {
            background: transparent;
            margin: 5px 0;
        }

        .sidebar-scroll-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-scroll-container::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Overlay untuk mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Tombol close di sidebar */
        .sidebar-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 1001;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .sidebar-close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Main content tidak terpengaruh */
        .main-content-unaffected {
            width: 100%;
            margin-left: 0;
            transition: none;
        }

        /* Desktop behavior - Sidebar selalu terbuka */
        @media (min-width: 768px) {
            .sidebar-modal {
                position: fixed;
            }

            .sidebar-overlay {
                display: none;
            }

            .main-content-unaffected {
                margin-left: 280px;
                width: calc(100% - 280px);
            }

            /* Sembunyikan tombol toggle di desktop */
            .sidebar-toggle-btn {
                display: none;
            }
        }

        /* Mobile behavior */
        @media (max-width: 767px) {
            .sidebar-modal {
                width: 85vw;
                max-width: 300px;
            }

            .main-content-unaffected {
                margin-left: 0;
                width: 100%;
            }

            /* Tampilkan tombol toggle di mobile */
            .sidebar-toggle-btn {
                display: flex;
            }
        }

        /* Improved hover effects */
        .hover-scale {
            transition: all 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .modal-overlay {
            z-index: 9999 !important;
        }

        #pageLoader {
            transition: opacity 0.3s ease;
        }

        #pageLoader.hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body class="font-sans antialiased"
    style="background: url('/images/Gambar3.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="h-screen bg-gray-100/40 dark:bg-gray-900/70 flex overflow-hidden" x-data="{
        sidebarOpen: false,
        initialized: false,
    
        init() {
            // Set initial state dari localStorage atau screen size
            const savedState = localStorage.getItem('sidebarOpen');
            if (savedState !== null) {
                this.sidebarOpen = savedState === 'true';
            } else {
                this.sidebarOpen = window.innerWidth >= 768;
            }
    
            // Tandai sudah initialized
            this.initialized = true;
    
            // Simpan state changes
            this.$watch('sidebarOpen', (value) => {
                if (this.initialized) {
                    localStorage.setItem('sidebarOpen', value);
                }
            });
    
            // Handle resize dengan proper cleanup
            const handleResize = () => {
                if (window.innerWidth >= 768) {
                    this.sidebarOpen = true;
                } else {
                    this.sidebarOpen = false;
                }
            };
    
            window.addEventListener('resize', handleResize);
        }
    }" x-cloak>

        <!-- Sidebar Overlay untuk Mobile -->
        <div class="sidebar-overlay" :class="{ 'active': sidebarOpen && window.innerWidth < 768 }"
            x-show="sidebarOpen && window.innerWidth < 768" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false" x-cloak>
        </div>

        <!-- Sidebar Modal -->
        <aside class="sidebar-modal text-white h-screen flex flex-col z-50" x-show="sidebarOpen"
            x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-cloak>

            <!-- Tombol Close di dalam sidebar (hanya mobile) -->
            <button @click="sidebarOpen = false" class="sidebar-close-btn md:hidden"
                x-show="sidebarOpen && window.innerWidth < 768">
                <i class="fa-solid fa-times text-sm"></i>
            </button>

            <!-- Konten Sidebar dengan auto-close untuk mobile -->
            <div class="flex-1 overflow-hidden sidebar-scroll" x-data="{
                closeSidebarOnClick() {
                    if (window.innerWidth < 768) {
                        // Dapatkan instance Alpine.js utama
                        const mainAlpineElement = document.querySelector('[x-data]');
                        if (mainAlpineElement && mainAlpineElement.__x) {
                            Alpine.$data(mainAlpineElement).sidebarOpen = false;
                        }
                    }
                }
            }">
                <!-- Include sidebar content dengan event listener -->
                <div @click="closeSidebarOnClick()">
                    @include('layouts.sidebar')
                </div>
            </div>
        </aside>

        <!-- Main Content - TIDAK TERPENGARUH oleh sidebar -->
        <div class="main-content-unaffected flex-1 flex flex-col min-h-0">

            <!-- Top Navbar -->
            <nav
                class="bg-white/95 backdrop-blur-sm shadow px-4 md:px-6 py-3 flex justify-between items-center sticky top-0 z-40">

                <div class="flex items-center w-full justify-between">
                    <!-- Tombol Toggle Sidebar - HANYA MOBILE -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="sidebar-toggle-btn mr-3 md:mr-4 p-2 rounded-md text-gray-600 hover:text-green-600 hover:bg-green-50 transition duration-200">
                        <i class="fa-solid fa-bars text-lg md:text-xl"></i>
                    </button>

                    <!-- 🔍 Form Pencarian (Menggantikan Logo) -->
                    <form action="{{ route('search') }}" method="GET" id="globalSearchForm"
                        class="relative w-[180px] sm:w-[240px] md:w-[320px] lg:w-[400px] mx-2">
                        {{-- Input utama --}}
                        <input type="text" name="search" value="{{ request('search') }}" required placeholder=""
                            class="block w-full text-sm h-[38px] sm:h-[42px] px-3 sm:px-4 text-gray-900 bg-white rounded-lg border border-gray-300
                focus:border-transparent focus:outline focus:outline-2 focus:outline-green-500 focus:ring-0
                hover:border-green-400 peer overflow-ellipsis pr-[40px]"
                            id="floating_outlined" />

                        {{-- Label mengambang --}}
                        <label for="floating_outlined"
                            class="absolute text-[12px] sm:text-[13px] leading-[150%] text-green-600 duration-300 transform
                -translate-y-[1rem] scale-75 top-2 z-10 origin-[0] bg-white px-1 sm:px-2
                peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2
                peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75
                peer-focus:-translate-y-[1rem] start-1">
                            Cari Data...
                        </label>

                        {{-- Ikon Search --}}
                        <button type="submit" id="searchButton"
                            class="absolute top-[8px] sm:top-[9px] right-3 text-green-500 hover:text-green-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.2-5.2m1.7-4.3a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>

                        {{-- Loader Spinner --}}
                        <div id="searchLoader"
                            class="hidden absolute top-[8px] sm:top-[9px] right-3 w-5 h-5 border-2 border-green-500 border-t-transparent rounded-full animate-spin">
                        </div>
                    </form>

                    <!-- Bagian kanan: Notifikasi + Setting + Profil -->
                    <div class="flex items-center space-x-4 md:space-x-6">
                        <!-- Notifikasi -->
                        <button class="relative text-gray-800 hover:text-green-800 hover:scale-105 transition">
                            <i class="fa-regular fa-bell text-lg md:text-xl"></i>
                            <span
                                class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1 min-w-[16px] text-center">3</span>
                        </button>

                        <!-- Dropdown Setting -->
                        <div x-data="{ openSetting: false }" class="relative">
                            <button @click="openSetting = !openSetting"
                                class="text-gray-800 hover:text-green-800 focus:outline-none hover:scale-110 transition-transform duration-200">
                                <i class="fa-solid fa-gear text-lg md:text-xl"></i>
                            </button>

                            <div x-show="openSetting" @click.away="openSetting = false" x-transition
                                class="absolute right-0 mt-2 w-44 sm:w-48 md:w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <ul class="py-2 text-gray-700 text-sm md:text-base">

                                    {{-- ✅ Kelola Data User --}}
                                    @canAdmin
                                    <li>
                                        <a href="{{ route('users.index') }}"
                                            class="flex items-center px-3 md:px-4 py-2 hover:bg-gray-100 transition">
                                            <i
                                                class="fa-solid fa-user-plus mr-2 text-green-600 text-sm md:text-base"></i>
                                            Kelola Data User
                                        </a>
                                    </li>
                                @else
                                    <li class="opacity-50 pointer-events-none cursor-not-allowed select-none">
                                        <div class="flex items-center px-3 md:px-4 py-2">
                                            <i
                                                class="fa-solid fa-user-plus mr-2 text-gray-400 text-sm md:text-base"></i>
                                            Kelola Data User
                                        </div>
                                    </li>
                                    @endcanAdmin

                                    {{-- ✅ Laporan Aktivitas --}}
                                    @canAdmin
                                    <li>
                                        <a href="{{ route('activity.report') }}"
                                            class="flex items-center px-3 md:px-4 py-2 hover:bg-gray-100 transition">
                                            <i
                                                class="fa-solid fa-chart-line mr-2 text-blue-600 text-sm md:text-base"></i>
                                            Laporan Aktivitas
                                        </a>
                                    </li>
                                @else
                                    <li class="opacity-50 pointer-events-none cursor-not-allowed select-none">
                                        <div class="flex items-center px-3 md:px-4 py-2">
                                            <i
                                                class="fa-solid fa-chart-line mr-2 text-gray-400 text-sm md:text-base"></i>
                                            Laporan Aktivitas
                                        </div>
                                    </li>
                                    @endcanAdmin

                                </ul>
                            </div>
                        </div>

                        <!-- Profil Pengguna -->
                        
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center space-x-3 group hover:bg-green-50 px-2 py-1 rounded-lg transition duration-200 hover:scale-105">

                            @php
                                $user = Auth::user();
                                $avatar =
                                    'https://ui-avatars.com/api/?name=' .
                                    urlencode($user->name) .
                                    '&background=047857&color=fff';
                            @endphp

                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : $avatar }}"
                                class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover border-2 border-white shadow-md group-hover:scale-105 transition"
                                alt="Foto Profil">

                            <div class="hidden sm:block text-left">
                                <h2
                                    class="font-semibold text-sm text-gray-700 group-hover:text-green-700 truncate max-w-[120px] sm:max-w-[150px] md:max-w-[180px]">
                                    {{ $user->name }}
                                </h2>
                                <p
                                    class="text-xs text-gray-500 truncate max-w-[120px] sm:max-w-[150px] md:max-w-[180px]">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </nav>


            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm shadow">
                    <div class="max-w-7xl mx-auto py-4 md:py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-sm md:text-base">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 p-3 md:p-4 overflow-y-auto">
                <div class="max-w-full">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <x-footer />
        </div>
    </div>



    <!-- 🌿 Global Page Loader -->
    <div id="pageLoader"
        class="hidden fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-[9999]">

        <!-- 🔹 Spinner Keren dari SmookyDev -->
        <div
            class="w-32 aspect-square rounded-full relative flex justify-center items-center animate-[spin_3s_linear_infinite] z-40 bg-[conic-gradient(white_0deg,white_300deg,transparent_270deg,transparent_360deg)]
        before:animate-[spin_2s_linear_infinite] before:absolute before:w-[60%] before:aspect-square before:rounded-full before:z-[80]
        before:bg-[conic-gradient(white_0deg,white_270deg,transparent_180deg,transparent_360deg)]
        after:absolute after:w-3/4 after:aspect-square after:rounded-full after:z-[60]
        after:animate-[spin_3s_linear_infinite]
        after:bg-[conic-gradient(#065f46_0deg,#065f46_180deg,transparent_180deg,transparent_360deg)]">
            <span
                class="absolute w-[85%] aspect-square rounded-full z-[60] animate-[spin_5s_linear_infinite]
            bg-[conic-gradient(#34d399_0deg,#34d399_180deg,transparent_180deg,transparent_360deg)]">
            </span>
        </div>
    </div>
</body>

<script>
    // Immediate hide untuk x-cloak elements
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('[x-cloak]');
        elements.forEach(el => {
            el.style.display = 'none';
        });
    });
</script>

<script>
    // Prevent body scroll when sidebar is open on mobile
    document.addEventListener('alpine:init', () => {
        Alpine.effect(() => {
            const alpineElement = document.querySelector('[x-data]');
            if (alpineElement && alpineElement.__x) {
                const sidebarOpen = Alpine.$data(alpineElement).sidebarOpen;
                const isMobile = window.innerWidth < 768;

                if (sidebarOpen && isMobile) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        });
    });

    // Close sidebar when route changes (untuk mobile)
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                const alpineElement = document.querySelector('[x-data]');
                if (alpineElement && alpineElement.__x && window.innerWidth < 768) {
                    Alpine.$data(alpineElement).sidebarOpen = false;
                }
            });
        });
    });

    // Handle resize untuk update state sidebar
    window.addEventListener('resize', function() {
        const alpineElement = document.querySelector('[x-data]');
        if (alpineElement && alpineElement.__x) {
            const sidebarState = Alpine.$data(alpineElement);
            if (window.innerWidth >= 768) {
                sidebarState.sidebarOpen = true;
            } else {
                sidebarState.sidebarOpen = false;
            }
        }
    });

    // Auto close sidebar ketika menu di-klik di mobile
    document.addEventListener('DOMContentLoaded', function() {
        // Function untuk close sidebar
        function closeSidebar() {
            const alpineElement = document.querySelector('[x-data]');
            if (alpineElement && alpineElement.__x && window.innerWidth < 768) {
                Alpine.$data(alpineElement).sidebarOpen = false;
            }
        }

        // Event delegation untuk semua link di sidebar
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            const sidebar = e.target.closest('.sidebar-modal');

            // Jika yang di-klik adalah link di dalam sidebar DAN di mobile
            if (link && sidebar && window.innerWidth < 768) {
                // Tunggu sedikit untuk memastikan click event diproses
                setTimeout(closeSidebar, 100);
            }
        });

        // Juga handle untuk dropdown items di sidebar jika ada
        document.addEventListener('click', function(e) {
            const dropdownItem = e.target.closest('.dropdown-item, [x-data] a');
            const sidebar = e.target.closest('.sidebar-modal');

            if (dropdownItem && sidebar && window.innerWidth < 768) {
                setTimeout(closeSidebar, 100);
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new MutationObserver(() => {
            const modal = document.querySelector('.modal.show, [role="dialog"].show');
            const sidebar = document.querySelector('.sidebar-modal');
            const overlay = document.querySelector('#global-modal-overlay');

            if (modal) {
                // Tambahkan overlay kalau belum ada
                if (!overlay) {
                    const newOverlay = document.createElement('div');
                    newOverlay.id = 'global-modal-overlay';
                    newOverlay.style.position = 'fixed';
                    newOverlay.style.top = 0;
                    newOverlay.style.left = 0;
                    newOverlay.style.width = '100vw';
                    newOverlay.style.height = '100vh';
                    newOverlay.style.background = 'rgba(0,0,0,0.5)';
                    newOverlay.style.zIndex = 1500;
                    newOverlay.style.backdropFilter = 'blur(2px)';
                    document.body.appendChild(newOverlay);
                }

                // Matikan sidebar & body scroll
                if (sidebar) sidebar.style.pointerEvents = 'none';
                document.body.style.overflow = 'hidden';
            } else {
                // Hapus overlay dan aktifkan kembali sidebar
                if (overlay) overlay.remove();
                if (sidebar) sidebar.style.pointerEvents = 'auto';
                document.body.style.overflow = '';
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
</script>

<script>
    document.getElementById('globalSearchForm').addEventListener('submit', function(e) {
        const pageLoader = document.getElementById('pageLoader');

        // Tampilkan overlay spinner
        pageLoader.classList.remove('hidden');

        // Supaya spinner sempat kelihatan
        e.preventDefault();
        setTimeout(() => this.submit(), 3000);
    });
</script>



</html>
