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
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">📂 Dokumen MoU Institut IAIT</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition text-sm md:text-base">
                    + Tambah Dokumen
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
                            <th class="px-4 py-2 border">Keterangan</th>
                            <th class="px-4 py-2 border text-center">File</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen_iait as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-4 py-2">{{ $item->judul_mou }}</td>
                                <td class="border px-4 py-2">{{ $item->nomor_mou ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->lembaga_mitra ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->jenis_kerjasama ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->tingkat_kerjasama ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->tanggal_ttd ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->masa_berlaku ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->penanggung_jawab ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>

                                <!-- File -->
                                <td class="border px-4 py-2 text-center">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="text-blue-600 underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="border px-4 py-2 text-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button @click="editId = {{ $item->id }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <!-- Modal Edit -->
                                    <div x-show="editId === {{ $item->id }}" x-cloak
                                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
                                        <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                                            <h2 class="text-lg font-bold mb-4">Edit Dokumen</h2>
                                            <form action="{{ route('dokumen_iait.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="space-y-2 text-sm">
                                                    <input type="text" name="judul_mou"
                                                        value="{{ $item->judul_mou }}" placeholder="Judul MoU" required
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="text" name="nomor_mou"
                                                        value="{{ $item->nomor_mou }}" placeholder="Nomor MoU"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="text" name="lembaga_mitra"
                                                        value="{{ $item->lembaga_mitra }}" placeholder="Lembaga Mitra"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="text" name="jenis_kerjasama"
                                                        value="{{ $item->jenis_kerjasama }}"
                                                        placeholder="Jenis Kerjasama"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="text" name="tingkat_kerjasama"
                                                        value="{{ $item->tingkat_kerjasama }}"
                                                        placeholder="Tingkat Kerjasama"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="date" name="tanggal_ttd"
                                                        value="{{ $item->tanggal_ttd }}"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="text" name="masa_berlaku"
                                                        value="{{ $item->masa_berlaku }}" placeholder="Masa Berlaku"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="text" name="penanggung_jawab"
                                                        value="{{ $item->penanggung_jawab }}"
                                                        placeholder="Penanggung Jawab"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <textarea name="keterangan" placeholder="Keterangan" class="w-full border px-2 py-1 rounded">{{ $item->keterangan }}</textarea>

                                                    <input type="file" name="file_dokumen" class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">  

                                                    @if ($item->file_dokumen)
                                                        <p class="text-sm mb-1 text-start">
                                                            File lama:
                                                            <a href="{{ asset('storage/' . $item->file_dokumen) }}"
                                                                target="_blank"
                                                                class="text-blue-600 underline">Lihat</a>
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="flex justify-end space-x-2 mt-4">
                                                    <button type="button" @click="editId = null"
                                                        class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-green-600 text-white rounded text-sm">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('dokumen_iait.destroy', $item->id) }}" method="POST"
                                        class="inline">
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
                                <td colspan="11" class="text-center py-4 text-gray-500 bg-gray-50">
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
            <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                <h2 class="text-lg font-bold mb-4">Tambah Dokumen</h2>
                <form action="{{ route('dokumen_iait.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-2 text-sm">
                        <input type="text" name="judul_mou" placeholder="Judul MoU" required
                            class="w-full border px-2 py-1 rounded">
                        <input type="text" name="nomor_mou" placeholder="Nomor MoU"
                            class="w-full border px-2 py-1 rounded">
                        <input type="text" name="lembaga_mitra" placeholder="Lembaga Mitra"
                            class="w-full border px-2 py-1 rounded">
                        <input type="text" name="jenis_kerjasama" placeholder="Jenis Kerjasama"
                            class="w-full border px-2 py-1 rounded">
                        <input type="text" name="tingkat_kerjasama" placeholder="Tingkat Kerjasama"
                            class="w-full border px-2 py-1 rounded">
                        <input type="date" name="tanggal_ttd" placeholder="Tanggal TTD"
                            class="w-full border px-2 py-1 rounded">
                        <input type="text" name="masa_berlaku" placeholder="Masa Berlaku"
                            class="w-full border px-2 py-1 rounded">
                        <input type="text" name="penanggung_jawab" placeholder="Penanggung Jawab"
                            class="w-full border px-2 py-1 rounded">
                        <textarea name="keterangan" placeholder="Keterangan" class="w-full border px-2 py-1 rounded"></textarea>
                        <input type="file" name="file_dokumen" class="text-sm w-full">
                    </div>

                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" @click="openTambah = false"
                            class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                        <button type="submit"
                            class="px-3 py-1 bg-green-600 text-white rounded text-sm">Simpan</button>
                    </div>
                </form>
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
