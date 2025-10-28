<aside class="sidebar-modal text-white h-screen flex flex-col z-40" :class="{ 'open': sidebarOpen }">

    <!-- Tombol Close -->
    <button @click="sidebarOpen = false" class="sidebar-close-btn md:hidden"
        x-show="sidebarOpen && window.innerWidth < 768">
        <i class="fa-solid fa-times text-sm"></i>
    </button>

    <!-- Container Scroll -->
    <div class="sidebar-scroll-container sidebar-scroll">

        <!-- Header Sidebar (SIPANDA - Super Clean Version) -->
        <div class="p-5 border-b border-green-800 flex items-center space-x-3">
            <img src="{{ asset('images/logo-iait.png') }}" alt="Logo IAIT" class="w-11 h-11 rounded-full shadow-md">
            <div class="leading-tight">
                <h2 class="text-white font-semibold text-base tracking-wide drop-shadow-sm">
                    SIPANDA
                </h2>
                <p class="text-green-200 text-xs italic">
                    Sistem Informasi Pusat Arsip & Data Akademik
                </p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto scrollbar-hide relative sidebar-scroll">
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto overflow-x-visible scrollbar-hide relative">
                <div class="flex-1 overflow-y-auto scrollbar-hide relative">
                    <!-- Navigation -->
                    <nav class="flex-1 overflow-y-auto overflow-x-visible scrollbar-hide relative">

                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                            <i class="fa-solid fa-gauge text-lg md:text-xl mr-3 w-6 text-center"></i>
                            <span class="menu-text">Dashboard</span>
                        </a>

                        <!-- Data Dosen -->
                        <a href="{{ route('dokumen-dosen.index') }}"
                            class="flex items-center px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                            <i class="fa-solid fa-chalkboard-user text-lg md:text-xl mr-3 w-6 text-center"></i>
                            <span class="menu-text">Data Dosen</span>
                        </a>

                        <!-- Data Tendik -->
                        <a href="{{ route('data_tendik.index') }}"
                            class="flex items-center px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                            <i class="fa-solid fa-user-gear text-lg md:text-xl mr-3 w-6 text-center"></i>
                            <span class="menu-text">Data Tendik</span>
                        </a>

                        <!-- Dropdown Dokumen MoU - Mobile Optimized -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                                <span class="flex items-center">
                                    <i class="fa-solid fa-handshake text-lg md:text-2xl mr-3 w-6 text-center"></i>
                                    <span class="menu-text">Dokumen MoU</span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-xs md:text-base transition-transform duration-300"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" x-cloak
                                class="bg-green-700 text-sm overflow-hidden transition-all duration-300">
                                <!-- Fakultas Ekonomi - Mobile Optimized -->
                                <div x-data="{ subOpen: false }" class="relative border-t border-green-500">
                                    <button @click="subOpen = !subOpen"
                                        class="w-full flex items-center justify-between px-6 md:px-10 py-2 hover:bg-green-500 transition duration-300">
                                        <span class="text-xs md:text-sm">Fak. Ekonomi & Bisnis Islam</span>
                                        <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                                            :class="subOpen ? 'rotate-90' : ''"></i>
                                    </button>

                                    <div x-show="subOpen" x-cloak
                                        class="bg-green-800 pl-4 md:pl-8 transition-all duration-300">
                                        <a href="{{ route('dokumen-ekonomi.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                            Ekonomi Syariah
                                        </a>
                                        <a href="{{ route('fakultas.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm">
                                            Fakultas Ekonomi
                                        </a>
                                    </div>
                                </div>

                                <!-- Fakultas Syariah - Mobile Optimized -->
                                <div x-data="{ subOpen: false }" class="relative border-t border-green-500">
                                    <button @click="subOpen = !subOpen"
                                        class="w-full flex items-center justify-between px-6 md:px-10 py-2 hover:bg-green-500 transition duration-300">
                                        <span class="text-xs md:text-sm">Fakultas Syariah</span>
                                        <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                                            :class="subOpen ? 'rotate-90' : ''"></i>
                                    </button>

                                    <div x-show="subOpen" x-cloak
                                        class="bg-green-800 pl-4 md:pl-8 transition-all duration-300">
                                        <a href="{{ route('fakultas_syariahs.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                            Fakultas Syariah
                                        </a>
                                        <a href="{{ route('hki.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                           Prodi HKI
                                        </a>
                                        <a href="{{ route('dokumen_htn.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm">
                                            Prodi HTN
                                        </a>
                                    </div>
                                </div>

                                <!-- Fakultas Tarbiyah - Mobile Optimized -->
                                <div x-data="{ subOpen: false }" class="relative border-t border-green-600">
                                    <button @click="subOpen = !subOpen"
                                        class="w-full flex items-center justify-between px-6 md:px-10 py-2 hover:bg-green-500 transition duration-300">
                                        <span class="text-xs md:text-sm">Fak. Tarbiyah & Keguruan</span>
                                        <i class="fa-solid fa-chevron-right text-xs transition-transform duration-300"
                                            :class="subOpen ? 'rotate-90' : ''"></i>
                                    </button>

                                    <div x-show="subOpen" x-cloak
                                        class="bg-green-800 pl-4 md:pl-8 transition-all duration-300">
                                        <a href="{{ route('prodi_bkpi.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                            Prodi BKPI
                                        </a>
                                        <a href="{{ route('fakultas_tarbiyah.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                            Fakultas Tarbiyah
                                        </a>
                                        <a href="{{ route('dokumen_mpi.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                            Prodi MPI
                                        </a>
                                        <a href="{{ route('dokumen_piaud.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                           Prodi PIAUD
                                        </a>
                                        <a href="{{ route('dokumen_pai.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                           Prodi PAI
                                        </a>
                                        <a href="{{ route('dokumen_pgmi.index') }}"
                                            class="block px-4 md:px-6 py-2 hover:bg-green-500 text-xs md:text-sm border-b border-green-500">
                                            Prodi PGMI
                                        </a>
                                    </div>
                                </div>

                                <!-- Institut IAIT -->
                                <a href="{{ route('dokumen_iait.index') }}"
                                    class="block px-6 md:px-10 py-2 hover:bg-green-500 text-xs md:text-sm border-t border-green-500 transition duration-300">
                                    Institut IAIT
                                </a>

                                <!-- Pascasarjana -->
                                <a href="{{ route('dokumen_pascasarjana.index') }}"
                                    class="block px-6 md:px-10 py-2 hover:bg-green-500 text-xs md:text-sm border-t border-green-500 transition duration-300">
                                    Pascasarjana
                                </a>
                            </div>
                        </div>

                        <!-- Dropdown Dokumen SK - Mobile Optimized -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                                <span class="flex items-center">
                                    <i class="fa-solid fa-stamp text-lg md:text-2xl mr-3 w-6 text-center"></i>
                                    <span class="menu-text">Dokumen SK</span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-xs md:text-base transition-transform duration-300"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" x-cloak class="bg-green-700 text-sm transition-all duration-300">
                                <a href="{{ route('dokumen_sk_institusi.index') }}"
                                    class="block px-6 md:px-10 py-2 hover:bg-green-500 text-xs md:text-sm border-t border-green-500">
                                    Institusi
                                </a>
                                <a href="{{ route('dokumen_sk_mahasiswa.index') }}"
                                    class="block px-6 md:px-10 py-2 hover:bg-green-500 text-xs md:text-sm border-t border-green-500">
                                    Mahasiswa
                                </a>
                            </div>
                        </div>

                        <!-- Dokumen ST -->
                        <a href="{{ route('dokumen_st.index') }}"
                            class="flex items-center px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                            <i class="fa-solid fa-envelope-open-text text-lg md:text-2xl mr-3 w-6 text-center"></i>
                            <span class="menu-text">Dokumen ST</span>
                        </a>

                        <!-- Dokumen BA -->
                        <a href="{{ route('dokumen_ba.index') }}"
                            class="flex items-center px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                            <i class="fa-solid fa-file-invoice text-lg md:text-2xl mr-3 w-6 text-center"></i>
                            <span class="menu-text">Dokumen BA</span>
                        </a>

                        <!-- Data Sarpras -->
                        <a href="{{ route('data_sarpras.index') }}"
                            class="flex items-center px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                            <i class="fa-solid fa-building-columns text-lg md:text-2xl mr-3 w-6 text-center"></i>
                            <span class="menu-text">Data Sarpras</span>
                        </a>

                        <!-- Dokumen Peraturan -->
                        <a href="{{ route('dokumen_peraturan.index') }}"
                            class="flex items-center px-4 md:px-6 py-2 hover:bg-green-400 transition duration-300">
                            <i class="fa-solid fa-gavel text-lg md:text-2xl mr-3 w-6 text-center"></i>
                            <span class="menu-text">Dokumen Peraturan</span>
                        </a>

                    </nav>
                </div>

                <!-- Logout -->
                <div class="p-4 md:p-6 border-t border-green-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-2 bg-green-700 hover:bg-green-400 rounded-md transition duration-300 text-sm md:text-base">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>

                <style>
                    /* Responsive text sizing */
                    .menu-text {
                        font-size: 0.875rem;
                    }

                    @media (min-width: 768px) {
                        .menu-text {
                            font-size: 1rem;
                        }
                    }

                    /* Smooth transitions */
                    .transition-all {
                        transition: all 0.3s ease;
                    }

                    /* Ensure proper spacing on mobile */
                    @media (max-width: 767px) {
                        .fa-solid {
                            min-width: 24px;
                            text-align: center;
                        }
                    }

                    /* Hide scrollbar but keep functionality */
                    .scrollbar-hide {
                        -ms-overflow-style: none;
                        scrollbar-width: none;
                    }

                    .scrollbar-hide::-webkit-scrollbar {
                        display: none;
                    }
                </style>
            </nav>
        </div>
    </div>
</aside>