<x-app-layout>
    @php
        $highlight = request('highlight'); // ambil dari query string ?highlight=...
    @endphp
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Tambahan CSS untuk responsivitas tabel */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 768px) {

            .table-mobile-compact th:nth-child(n+4),
            .table-mobile-compact td:nth-child(n+4) {
                display: none;
            }

            .table-mobile-compact th:nth-child(-n+3),
            .table-mobile-compact td:nth-child(-n+3) {
                min-width: 120px;
            }
        }

        @media (max-width: 1024px) {
            .table-desktop-optimized {
                min-width: 1000px;
            }
        }

        /* 🔹 Biar toast-nya lebih kecil dan elegan */
        .swal2-popup.small-toast {
            font-size: 0.85rem !important;
            padding: 0.75rem 1rem !important;
            min-width: 220px !important;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ubah warna centang jadi hijau */
        input[type="checkbox"]:checked {
            accent-color: #16a34a;
            /* green-600 */
        }

        /* kalau accent-color gak didukung browser */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* checkbox biar gak ganggu */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* 🔥 Efek highlight cepat (1 detik, pudar halus) */
        @keyframes fadeHighlight {
            0% {
                background-color: #fde68a;
                /* kuning terang */
            }

            70% {
                background-color: #fef3c7;
                /* kuning lembut */
            }

            100% {
                background-color: transparent;
            }
        }

        .fade-once {
            animation: fadeHighlight 5s ease-out forwards;
            /* 1 detik aja */
        }
    </style>

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">📂 Data Tenaga Kependidikan</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Data
                </button>
            </div>

            <form id="bulkDeleteForm" action="{{ route('data_tendik.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-between items-center mb-2">  
                    <button type="submit"
                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 disabled:opacity-50"
                        id="deleteSelected" disabled>
                        Hapus Terpilih
                    </button>
                </div>

                <!-- Tabel Data dengan Container Responsif -->
                <div class="table-wrapper border border-gray-200 rounded-lg">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-green-600 text-white">
                            <tr>
                                <th class="px-4 py-2 border text-center">
                                    <input type="checkbox" id="selectAll"
                                        class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                </th>
                                <th class="px-3 py-2 border">No</th>
                                <th class="px-3 py-2 border">Nama</th>
                                <th class="px-3 py-2 border">NIP</th>
                                <th class="px-3 py-2 border">Jabatan</th>
                                <th class="px-3 py-2 border">Status</th>
                                <th class="px-3 py-2 border">Pendidikan</th>
                                <th class="px-3 py-2 border">Gender</th>
                                <th class="px-3 py-2 border">No HP</th>
                                <th class="px-3 py-2 border">Email</th>
                                <th class="px-3 py-2 border">Alamat</th>
                                <th class="px-3 py-2 border">Keterangan</th>
                                <th class="px-3 py-2 border text-center">Foto</th>
                                <th class="px-3 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_tendik as $index => $item)
                                <tr id="row-{{ $item->id }}"
                                    class="
                                        {{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}
                                        {{ $highlight &&
                                        (str_contains(strtolower($item->nama_tendik), strtolower($highlight)) ||
                                            str_contains(strtolower($item->nip ?? ''), strtolower($highlight)) ||
                                            str_contains(strtolower($item->jabatan ?? ''), strtolower($highlight)))
                                            ? 'fade-once'
                                            : '' }}
                                    ">
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                    </td>
                                   <td class="border px-4 py-2 text-center">{{ $data_tendik->firstItem() + $index }}
                                    <td class="border px-3 py-2">{{ $item->nama_tendik }}</td>
                                    <td class="border px-3 py-2">{{ $item->nip ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $item->jabatan }}</td>
                                    <td class="border px-3 py-2">{{ $item->status_kepegawaian }}</td>
                                    <td class="border px-3 py-2">{{ $item->pendidikan_terakhir }}</td>
                                    <td class="border px-3 py-2">{{ $item->jenis_kelamin }}</td>
                                    <td class="border px-3 py-2">{{ $item->no_hp ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $item->email ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $item->alamat ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $item->keterangan ?? '-' }}</td>

                                    <!-- Foto -->
                                    <td class="border px-3 py-2 text-center">
                                        @if ($item->foto)
                                            <a href="{{ asset('storage/' . $item->foto) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 transition underline">Lihat
                                                Foto</a>
                                        @else
                                            <span class="text-gray-400 italic">Belum ada</span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <!-- Edit -->
                                            <button @click="editId = {{ $item->id }}"
                                                class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>

                                            <!-- Hapus -->
                                            <form action="{{ route('data_tendik.destroy', $item) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn-hapus p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center py-4 text-gray-500">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- ✅ Tambahkan ini di bawah tabel --}}
                @include('components.pagination', ['data' => $data_tendik])

                <!-- Modal Tambah -->
                <div x-show="openTambah" x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
                    <div
                        class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto transition transform scale-100">
                        <!-- Header -->
                        <div class="bg-green-600 text-white p-4 rounded-t-lg">
                            <h2 class="text-lg font-semibold">Tambah Data Tenaga Kependidikan</h2>
                        </div>

                        <form action="{{ route('data_tendik.store') }}" method="POST" enctype="multipart/form-data"
                            class="p-5">
                            @csrf

                            <!-- Grid 2 kolom dengan jarak yang lebih baik -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Kolom Kiri -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tenaga
                                            Kependidikan</label>
                                        <input type="text" name="nama_tendik" placeholder="Masukkan nama lengkap"
                                            required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                        <input type="text" name="nip" placeholder="Masukkan NIP"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <select name="jabatan" required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">-- Pilih Jabatan --</option>
                                            <option value="Staff Administrasi">Staff Administrasi</option>
                                            <option value="Teknisi">Teknisi</option>
                                            <option value="Satpam">Satpam</option>
                                            <option value="Petugas Kebersihan">Petugas Kebersihan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status
                                            Kepegawaian</label>
                                        <select name="status_kepegawaian" required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="PNS">PNS</option>
                                            <option value="Honorer">Honorer</option>
                                            <option value="Kontrak">Kontrak</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan
                                            Terakhir</label>
                                        <select name="pendidikan_terakhir" required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">-- Pilih Pendidikan --</option>
                                            <option value="SMA/SMK">SMA/SMK</option>
                                            <option value="D3">D3</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                            Kelamin</label>
                                        <select name="jenis_kelamin" required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                                        <input type="text" name="no_hp" placeholder="Masukkan nomor HP"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" placeholder="Masukkan email"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                        <select name="keterangan"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">-- Pilih Keterangan --</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Cuti">Cuti</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto</label>
                                        <input type="file" name="foto" accept="image/*"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat (full width) -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <textarea name="alamat" placeholder="Masukkan alamat lengkap" rows="3"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-end mt-6 space-x-3">
                                <button type="button" @click="openTambah = false"
                                    class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Modal Edit -->
                <div x-show="editId !== null" x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                        <!-- Header -->
                        <div class="bg-green-600 text-white p-4 rounded-t-lg">
                            <h2 class="text-lg font-semibold">Edit Data Tenaga Kependidikan</h2>
                        </div>

                        <template x-for="item in {{ json_encode($data_tendik->items()) }}" :key="item.id">
                            <form x-show="editId === item.id" :action="`/data_tendik/${item.id}`" method="POST"
                                enctype="multipart/form-data" class="p-5">
                                @csrf
                                @method('PUT')

                                <!-- Grid 2 kolom dengan jarak yang lebih baik -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Kolom Kiri -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tenaga
                                                Kependidikan</label>
                                            <input type="text" name="nama_tendik" x-model="item.nama_tendik"
                                                required
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                            <input type="text" name="nip" x-model="item.nip"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                            <select name="jabatan" x-model="item.jabatan" required
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="Staff Administrasi">Staff Administrasi</option>
                                                <option value="Teknisi">Teknisi</option>
                                                <option value="Satpam">Satpam</option>
                                                <option value="Petugas Kebersihan">Petugas Kebersihan</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Status
                                                Kepegawaian</label>
                                            <select name="status_kepegawaian" x-model="item.status_kepegawaian"
                                                required
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="PNS">PNS</option>
                                                <option value="Honorer">Honorer</option>
                                                <option value="Kontrak">Kontrak</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan
                                                Terakhir</label>
                                            <select name="pendidikan_terakhir" x-model="item.pendidikan_terakhir"
                                                required
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="SMA/SMK">SMA/SMK</option>
                                                <option value="D3">D3</option>
                                                <option value="S1">S1</option>
                                                <option value="S2">S2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                                Kelamin</label>
                                            <select name="jenis_kelamin" x-model="item.jenis_kelamin" required
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                                            <input type="text" name="no_hp" x-model="item.no_hp"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" name="email" x-model="item.email"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                            <select name="keterangan" x-model="item.keterangan"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="Aktif">Aktif</option>
                                                <option value="Cuti">Cuti</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload
                                                Foto</label>
                                            <input type="file" name="foto" accept="image/*"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <template x-if="item.foto">
                                                <div class="text-xs mt-1 text-blue-600">
                                                    <span>Foto saat ini: </span>
                                                    <a :href="`/storage/${item.foto}`" target="_blank"
                                                        class="underline">Lihat</a>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat (full width) -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                    <textarea name="alamat" x-model="item.alamat" rows="3"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end mt-6 space-x-3">
                                    <button type="button" @click="editId = null"
                                        class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                                        Simpan Data
                                    </button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ✅ Notifikasi sukses (pojok kanan atas)
        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                background: '#f9fafb',
                color: '#1f2937',
                iconColor: '#22c55e',
                customClass: {
                    popup: 'small-toast shadow-lg rounded-xl border border-gray-200'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        @endif

        // ✅ Notifikasi error
        @if (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#fef2f2',
                color: '#991b1b',
                iconColor: '#ef4444',
                customClass: {
                    popup: 'small-toast shadow-lg rounded-xl border border-gray-200'
                }
            });
        @endif

        // ✅ Konfirmasi hapus (masih modal besar, biar jelas)
        document.querySelectorAll('.btn-hapus').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: 'Hapus data ini?',
                    text: 'Tindakan ini tidak bisa dibatalkan.',
                    icon: 'warning',
                    background: '#f9fafb',
                    color: '#1f2937',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data berhasil dihapus!',
                            showConfirmButton: false,
                            timer: 1500,
                            background: '#f9fafb',
                            color: '#1f2937',
                            iconColor: '#22c55e',
                            customClass: {
                                popup: 'small-toast shadow-lg rounded-xl border border-gray-200'
                            }
                        });
                        setTimeout(() => form.submit(), 1000);
                    }
                });
            });
        });
    </script>

    <script>
        // 🔹 SweetAlert untuk hapus banyak data (checkbox)
        const bulkForm = document.getElementById('bulkDeleteForm');
        const bulkDeleteBtn = document.getElementById('deleteSelected');

        if (bulkForm && bulkDeleteBtn) {
            bulkForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const checked = document.querySelectorAll('.select-item:checked');
                if (checked.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Belum ada data yang dipilih',
                        text: 'Silakan centang data yang ingin dihapus.',
                        confirmButtonColor: '#22c55e',
                        background: '#f9fafb',
                        color: '#1f2937',
                        iconColor: '#22c55e',
                    });
                    return;
                }

                Swal.fire({
                    title: `Yakin ingin menghapus ${checked.length} data terpilih?`,
                    text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    background: '#f9fafb',
                    color: '#1f2937',
                    iconColor: '#ef4444',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkForm.submit();
                    }
                });
            });
        }
    </script>

    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.select-item');
        const deleteBtn = document.getElementById('deleteSelected');

        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            toggleDeleteButton();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', toggleDeleteButton));

        function toggleDeleteButton() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            deleteBtn.disabled = !anyChecked;
        }
    </script>

    @if (request()->has('highlight_id'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const row = document.getElementById('row-{{ request('highlight_id') }}');
                if (row) {
                    row.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    // Tambahkan efek highlight agar lebih jelas
                    row.classList.add('fade-once');
                }
            });
        </script>
    @endif
</x-app-layout>
