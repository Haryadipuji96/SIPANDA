<x-app-layout>
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
    </style>

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">📂 Data Tenaga Kependidikan</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Data
                </button>
            </div>

            <!-- Tabel Data dengan Container Responsif -->
            <div id="table-wrapper" class="overflow-x-auto border rounded-lg">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
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
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition">
                                <td class="border px-3 py-2">{{ $index + 1 }}</td>
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
                                <td class="border px-3 py-2 text-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button @click="editId = {{ $item->id }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('data_tendik.destroy', $item->id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn-hapus text-red-600 hover:text-red-700 transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                            </svg>
                                        </button>
                                    </form>
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
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
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
                                        <input type="text" name="nama_tendik" x-model="item.nama_tendik" required
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
                                        <select name="status_kepegawaian" x-model="item.status_kepegawaian" required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="PNS">PNS</option>
                                            <option value="Honorer">Honorer</option>
                                            <option value="Kontrak">Kontrak</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan
                                            Terakhir</label>
                                        <select name="pendidikan_terakhir" x-model="item.pendidikan_terakhir" required
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
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                        <select name="keterangan" x-model="item.keterangan"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="Aktif">Aktif</option>
                                            <option value="Cuti">Cuti</option>
                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto</label>
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
</x-app-layout>
