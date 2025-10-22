<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* 🔹 Biar toast-nya lebih kecil dan elegan */
        .swal2-popup.small-toast {
            font-size: 0.85rem !important;
            padding: 0.75rem 1rem !important;
            min-width: 220px !important;
        }
    </style>

    <div class="p-4 md:p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-4 md:p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">📂 Dokumen MoU Institut Pascasarjana</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition text-sm md:text-base flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Dokumen
                </button>
            </div>

            <!-- Tabel Responsif -->
            <div class="w-full overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full table-auto text-sm border-collapse">
                    <thead class="bg-green-600 text-white text-left">
                        <tr>
                            <th class="px-4 py-2 border">Judul MoU</th>
                            <th class="px-4 py-2 border">Nomor MoU</th>
                            <th class="px-4 py-2 border">Lembaga Mitra</th>
                            <th class="px-4 py-2 border">Jenis Kerjasama</th>
                            <th class="px-4 py-2 border">Tingkat Kerjasama</th>
                            <th class="px-4 py-2 border">Tanggal TTD</th>
                            <th class="px-4 py-2 border">Masa Berlaku</th>
                            <th class="px-4 py-2 border">Penanggung Jawab</th>
                            <th class="px-4 py-2 border">Program Studi</th>
                            <th class="px-4 py-2 border">Jenis Kegiatan</th>
                            <th class="px-4 py-2 border">Keterangan</th>
                            <th class="px-4 py-2 border text-center">File</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen_pascasarjana as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-100' : 'bg-gray-50' }} hover:bg-gray-200">
                                <td class="border px-4 py-2">{{ $item->judul_mou }}</td>
                                <td class="border px-4 py-2">{{ $item->nomor_mou ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->lembaga_mitra ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->jenis_kerjasama ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->tingkat_kerjasama ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->tanggal_ttd ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->masa_berlaku ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->penanggung_jawab ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->program_studi ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->jenis_kegiatan ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>

                                <!-- File -->
                                <td class="border px-4 py-2 text-center">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 transition underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="border px-4 py-2 text-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button @click="editId = {{ $item->id }}"
                                        class="text-yellow-500 hover:text-yellow-700 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('dokumen_pascasarjana.destroy', $item->id) }}"
                                        method="POST" class="inline">
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
                                <td colspan="13" class="text-center py-4 text-gray-500 bg-gray-50">
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div x-show="openTambah" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="bg-green-600 text-white p-4 rounded-t-lg">
                    <h2 class="text-lg font-semibold">Tambah Dokumen MoU</h2>
                </div>

                <form action="{{ route('dokumen_pascasarjana.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-5">
                    @csrf

                    <!-- Grid 2 kolom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul MoU *</label>
                                <input type="text" name="judul_mou" placeholder="Masukkan judul MoU" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor MoU</label>
                                <input type="text" name="nomor_mou" placeholder="Masukkan nomor MoU"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lembaga Mitra</label>
                                <input type="text" name="lembaga_mitra" placeholder="Masukkan nama lembaga mitra"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kerjasama</label>
                                <input type="text" name="jenis_kerjasama" placeholder="Masukkan jenis kerjasama"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Kerjasama</label>
                                <input type="text" name="tingkat_kerjasama"
                                    placeholder="Masukkan tingkat kerjasama"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab</label>
                                <input type="text" name="penanggung_jawab" placeholder="Masukkan penanggung jawab"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal TTD</label>
                                <input type="date" name="tanggal_ttd"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku</label>
                                <input type="text" name="masa_berlaku" placeholder="Contoh: 3 tahun"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                <input type="text" name="program_studi" placeholder="Masukkan program studi"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kegiatan</label>
                                <input type="text" name="jenis_kegiatan" placeholder="Masukkan jenis kegiatan"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Dokumen</label>
                                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Maks. 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan (full width) -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" placeholder="Masukkan keterangan tambahan" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="openTambah = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                            Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="editId !== null" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="bg-green-600 text-white p-4 rounded-t-lg">
                    <h2 class="text-lg font-semibold">Edit Dokumen MoU</h2>
                </div>

                <template x-for="item in {{ json_encode($dokumen_pascasarjana) }}" :key="item.id">
                    <form x-show="editId === item.id" :action="`/dokumen_pascasarjana/${item.id}`" method="POST"
                        enctype="multipart/form-data" class="p-5">
                        @csrf
                        @method('PUT')

                        <!-- Grid 2 kolom -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Kolom Kiri -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul MoU *</label>
                                    <input type="text" name="judul_mou" x-model="item.judul_mou" required
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor MoU</label>
                                    <input type="text" name="nomor_mou" x-model="item.nomor_mou"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lembaga Mitra</label>
                                    <input type="text" name="lembaga_mitra" x-model="item.lembaga_mitra"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kerjasama</label>
                                    <input type="text" name="jenis_kerjasama" x-model="item.jenis_kerjasama"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat
                                        Kerjasama</label>
                                    <input type="text" name="tingkat_kerjasama" x-model="item.tingkat_kerjasama"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Penanggung
                                        Jawab</label>
                                    <input type="text" name="penanggung_jawab" x-model="item.penanggung_jawab"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal TTD</label>
                                    <input type="date" name="tanggal_ttd" x-model="item.tanggal_ttd"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku</label>
                                    <input type="text" name="masa_berlaku" x-model="item.masa_berlaku"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                    <input type="text" name="program_studi" x-model="item.program_studi"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kegiatan</label>
                                    <input type="text" name="jenis_kegiatan" x-model="item.jenis_kegiatan"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload File
                                        Dokumen</label>
                                    <input type="file" name="file_dokumen"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Maks. 5MB)
                                    </p>
                                    <template x-if="item.file_dokumen">
                                        <div class="text-xs mt-1 text-blue-600">
                                            <span>File saat ini: </span>
                                            <a :href="`/storage/${item.file_dokumen}`" target="_blank"
                                                class="underline">Lihat</a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan (full width) -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                            <textarea name="keterangan" x-model="item.keterangan" rows="3"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <button type="button" @click="editId = null"
                                class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm font-medium">
                                Update Dokumen
                            </button>
                        </div>
                    </form>
                </template>
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
                    title: 'Yakin ingin menghapus data ini?',
                    text: 'Data yang sudah dihapus tidak bisa dikembalikan.',
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
                            icon: 'info',
                            title: 'Menghapus data...',
                            showConfirmButton: false,
                            timer: 1500,
                            background: '#f9fafb',
                            color: '#1f2937',
                            iconColor: '#3b82f6',
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
