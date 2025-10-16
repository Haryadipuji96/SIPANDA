<!-- User Profile -->
<a href="{{ route('profile.edit') }}"
    class="p-6 border-b border-green-600 flex flex-col items-center hover:bg-green-400 transition duration-300 cursor-pointer">
    @php
        $user = Auth::user();
        $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=047857&color=fff';
    @endphp

    <img src="{{ Auth::user()->profile_photo
        ? asset('storage/' . Auth::user()->profile_photo)
        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}"
        class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" alt="Foto Profil">

    <h2 class="mt-3 font-bold text-lg">{{ $user->name }}</h2>
    <p class="text-sm text-green-200">{{ $user->email }}</p>
</a>

<div class="flex-1 overflow-y-auto scrollbar-hide relative">
    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto overflow-x-visible scrollbar-hide relative">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="block px-6 py-2 hover:bg-green-400 transition duration-300">
            <i class="fa-solid fa-gauge text-xl mr-3"></i> Dashboard
        </a>

        <!-- Data Dosen -->
        <a href="{{ route('dokumen-dosen.index') }}" class="block px-6 py-2 hover:bg-green-400 transition duration-300">
            <i class="fa-solid fa-chalkboard-user text-xl mr-3"></i> Data Dosen
        </a>

        <!-- Data Tendik -->
        <a href="{{ route('data_tendik.index') }}"
            class="block px-6 py-2 hover:bg-green-400 transition duration-300">
            <i class="fa-solid fa-user-gear text-xl mr-3"></i> Data Tendik
        </a>

        <!-- Dropdown Dokumen MoU -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-2 hover:bg-green-400">
                <span class="flex items-center">
                    <i class="fa-solid fa-handshake text-2xl mr-3"></i>
                    <span class="menu-text">Dokumen MoU</span>
                </span>
                <i class="fa-solid fa-chevron-down chevron-icon" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" class="bg-green-600 text-sm relative overflow-visible">

                <!-- Fakultas Ekonomi -->
                <div x-data="{ subOpen: false, posY: 0 }" @mouseenter="subOpen = true; posY = $el.getBoundingClientRect().top;"
                    @mouseleave="subOpen = false" class="relative">
                    <button class="w-full flex items-center justify-between px-10 py-2 hover:bg-green-500">
                        Fakultas Ekonomi dan Bisnis Islam
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <div x-cloak x-show="subOpen" :style="'position: fixed; left: 320px; top:' + posY + 'px;'"
                        class="w-56 bg-green-500 shadow-lg z-50 rounded-md">
                        <a href="{{ route('dokumen-ekonomi.index') }}" class="block px-6 py-2 hover:bg-green-400">
                            Ekonomi Syariah
                        </a>
                        <a href="{{ route('fakultas.index') }}" class="block px-6 py-2 hover:bg-green-400">
                            Fakultas
                        </a>
                    </div>
                </div>

                <!-- Fakultas Syariah -->
                <div x-data="{ subOpen: false, posY: 0 }" @mouseenter="subOpen = true; posY = $el.getBoundingClientRect().top;"
                    @mouseleave="subOpen = false" class="relative">
                    <button class="w-full flex items-center justify-between px-10 py-2 hover:bg-green-500">
                        Fakultas Syariah
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <div x-cloak x-show="subOpen" :style="'position: fixed; left: 320px; top:' + posY + 'px;'"
                        class="w-56 bg-green-500 shadow-lg z-50 rounded-md">
                        <a href="{{ route('fakultas_syariahs.index') }}"
                            class="block px-6 py-2 hover:bg-green-400">Fakultas Syariah</a>
                        <a href="{{ route('hki.index') }}" class="block px-6 py-2 hover:bg-green-400">HKI</a>
                        <a href="{{ route('dokumen_htn.index') }}"
                            class="block px-6 py-2 hover:bg-green-400">HTN</a>
                    </div>
                </div>

                <!-- Fakultas Tarbiyah -->
                <div x-data="{ subOpen: false, posY: 0 }"
                    @mouseenter="subOpen = true; posY = $el.getBoundingClientRect().top + window.scrollY;"
                    @mouseleave="subOpen = false" class="relative">
                    <button class="w-full flex items-center justify-between px-10 py-2 hover:bg-green-500">
                        Fakultas Tarbiyah dan Keguruan
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <template x-if="subOpen">
                        <div class="fixed left-[320px] w-56 bg-green-500 shadow-lg z-[9999]"
                            :style="`top: ${posY}px`">
                            <a href="{{ route('prodi_bkpi.index') }}"
                                class="block px-6 py-2 hover:bg-green-400">BKPI</a>
                            <a href="{{ route('fakultas_tarbiyah.index') }}"
                                class="block px-6 py-2 hover:bg-green-400">Fakultas</a>
                            <a href="{{ route('dokumen_mpi.index') }}"
                                class="block px-6 py-2 hover:bg-green-400">MPI</a>
                            <a href="{{ route('dokumen_piaud.index') }}"
                                class="block px-6 py-2 hover:bg-green-400">PIAUD</a>
                            <a href="{{ route('dokumen_pai.index') }}"
                                class="block px-6 py-2 hover:bg-green-400">PAI</a>
                            <a href="{{ route('dokumen_pgmi.index') }}"
                                class="block px-6 py-2 hover:bg-green-400">PGMI</a>
                        </div>
                    </template>
                </div>

                <!-- Institut IAIT -->
                <a href="{{ route('dokumen_iait.index') }}" class="block px-10 py-2 hover:bg-green-500">Institut
                    IAIT</a>

                <!-- Pascasarjana -->
                <a href="{{ route('dokumen_pascasarjana.index') }}"
                    class="block px-10 py-2 hover:bg-green-500">Pascasarjana</a>
            </div>
        </div>


        <!-- Dropdown Dokumen SK -->
        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
            <button class="w-full flex items-center justify-between px-6 py-2 hover:bg-green-400">
                <span class="flex items-center">
                    <i class="fa-solid fa-stamp text-2xl mr-3"></i>
                    <span class="menu-text">Dokumen SK</span>
                </span>
                <i class="fa-solid fa-chevron-down chevron-icon" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" class="bg-green-600 text-sm">
                <a href="{{ route('dokumen_sk_institusi.index') }}"
                    class="block px-10 py-2 hover:bg-green-400">Institusi</a>
                <a href="{{ route('dokumen_sk_mahasiswa.index') }}"
                    class="block px-10 py-2 hover:bg-green-400">Mahasiswa</a>
            </div>
        </div>

        <!-- Dokumen ST -->
        <a href="{{ route('dokumen_st.index') }}" class="block px-6 py-2 hover:bg-green-400 flex items-center">
            <i class="fa-solid fa-envelope-open-text text-2xl mr-3"></i>
            <span class="menu-text">Dokumen ST</span>
        </a>

        <!-- Dokumen BA -->
        <a href="{{ route('dokumen_ba.index') }}" class="block px-6 py-2 hover:bg-green-400 flex items-center">
            <i class="fa-solid fa-file-invoice text-2xl mr-3"></i>
            <span class="menu-text">Dokumen BA</span>
        </a>

        <!-- Data Sarpras -->
        <a href="{{ route('data_sarpras.index') }}" class="block px-6 py-2 hover:bg-green-400 flex items-center">
            <i class="fa-solid fa-building-columns text-2xl mr-3"></i>
            <span class="menu-text">Data Sarpras</span>
        </a>

        <!-- Dokumen Peraturan -->
        <a href="{{ route('dokumen_peraturan.index') }}"
            class="block px-6 py-2 hover:bg-green-400 flex items-center">
            <i class="fa-solid fa-gavel text-2xl mr-3"></i>
            <span class="menu-text">Dokumen Peraturan</span>
        </a>

    </nav>
</div>


<!-- Logout -->
<div class="p-6 border-t border-green-600">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-400 rounded-md transition duration-300">
            <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
        </button>
    </form>
</div>