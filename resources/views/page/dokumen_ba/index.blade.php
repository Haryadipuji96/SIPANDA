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

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    <div class="p-6" x-data="{ openTambah: false, editId: null }" x-cloak>
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">📑 Dokumen Berita Acara (BA)</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                    + Tambah Dokumen
                </button>
            </div>

            <!-- ✅ Tabel -->
            <div class="table-wrapper border border-gray-200 rounded-lg">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="border px-4 py-2">Judul</th>
                            <th class="border px-4 py-2">Nomor</th>
                            <th class="border px-4 py-2">Tanggal</th>
                            <th class="border px-4 py-2">Tempat</th>
                            <th class="border px-4 py-2">Pihak Terlibat</th>
                            <th class="border px-4 py-2">Keterangan</th>
                            <th class="border px-4 py-2">File</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen_ba as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-4 py-2 text-center">{{ $dokumen_ba->firstItem() + $index }}</td>
                                <td class="border px-4 py-2">{{ $item->judul }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->nomor_ba ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->tanggal_ba ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->tempat ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->pihak_terlibat ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="text-blue-600 underline">Lihat</a>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
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
                                        <form action="{{ route('dokumen_ba.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn-hapus p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- ✅ Modal Edit -->
                            <div x-show="editId === {{ $item->id }}" x-cloak
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
                                <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                                    <h2 class="text-lg font-bold mb-4 text-gray-700">Edit Dokumen</h2>
                                    <form action="{{ route('dokumen_ba.update', $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <input type="text" name="judul" value="{{ $item->judul }}" required
                                            class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                                        <input type="text" name="nomor_ba" value="{{ $item->nomor_ba }}"
                                            class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                                        <input type="date" name="tanggal_ba" value="{{ $item->tanggal_ba }}"
                                            class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                                        <input type="text" name="tempat" value="{{ $item->tempat }}"
                                            class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                                        <textarea name="pihak_terlibat" class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">{{ $item->pihak_terlibat }}</textarea>
                                        <textarea name="keterangan" class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">{{ $item->keterangan }}</textarea>

                                        <!-- ✅ File Upload -->
                                        <label class="block text-sm font-semibold text-gray-600 mb-1">Ganti File
                                            (opsional)
                                        </label>
                                        <input type="file" name="file_dokumen"
                                            class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                        @if ($item->file_dokumen)
                                            <div class="text-xs text-blue-600 mt-1">
                                                File saat ini:
                                                <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                                    class="underline hover:text-blue-800">Lihat Dokumen</a>
                                            </div>
                                        @endif

                                        <div class="flex justify-end space-x-2 mt-4">
                                            <button type="button" @click="editId = null"
                                                class="px-3 py-1 bg-gray-400 rounded text-sm text-white">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-gray-600">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @include('components.pagination', ['data' => $dokumen_ba])
        </div>

        <!-- ✅ Modal Tambah -->
        <div x-show="openTambah" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
            <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                <h2 class="text-lg font-bold mb-4 text-gray-700">Tambah Dokumen BA</h2>
                <form action="{{ route('dokumen_ba.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="judul" placeholder="Judul" required
                        class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                    <input type="text" name="nomor_ba" placeholder="Nomor"
                        class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                    <input type="date" name="tanggal_ba"
                        class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                    <input type="text" name="tempat" placeholder="Tempat"
                        class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200">
                    <textarea name="pihak_terlibat" placeholder="Pihak Terlibat"
                        class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200"></textarea>
                    <textarea name="keterangan" placeholder="Keterangan"
                        class="w-full border px-3 py-2 mb-2 rounded focus:ring focus:ring-green-200"></textarea>
                    <input type="file" name="file_dokumen"
                        class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                    <div class="flex justify-end space-x-2 mt-3">
                        <button type="button" @click="openTambah = false"
                            class="bg-gray-400 px-3 py-1 rounded text-sm text-white">Batal</button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Simpan</button>
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
