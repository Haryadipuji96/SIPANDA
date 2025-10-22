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

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2">
                    📂 Dokumen HTN</h1>
                <button @click="openTambah = true"
                    class="flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition duration-200 ease-in-out transform hover:scale-105">
                    + Tambah Dokumen
                </button>
            </div>

            <!-- Tabel -->
            <div class="table-wrapper border border-gray-200 rounded-lg">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Judul MoU</th>
                            <th class="px-4 py-2 border">Lembaga Mitra</th>
                            <th class="px-4 py-2 border">Nomor MoU</th>
                            <th class="px-4 py-2 border">Kategori</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">File</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen_htn as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-4 py-2 text-center">{{ $dokumen_htn->firstItem() + $index }}</td>
                                <td class="border px-4 py-2">{{ $item->judul_mou }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->lembaga_mitra ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->nomor_mou ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->kategori ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->deskripsi ?? '-' }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                        class="text-blue-600 underline">Lihat</a>
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
                                        <form action="{{ route('dokumen_htn.destroy', $item) }}" method="POST" class="inline">
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

                            <!-- Modal Edit -->
                            <div x-show="editId === {{ $item->id }}" x-cloak
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
                                <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                                    <h2 class="text-lg font-bold mb-4">Edit Dokumen</h2>
                                    <form action="{{ route('dokumen_htn.update', $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <input type="text" name="judul_mou" value="{{ $item->judul_mou }}" required
                                            class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                        <input type="text" name="lembaga_mitra" value="{{ $item->lembaga_mitra }}"
                                            required class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                        <input type="text" name="nomor_mou" value="{{ $item->nomor_mou }}" required
                                            class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                        <input type="text" name="kategori" value="{{ $item->kategori }}" required
                                            class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                        <textarea name="deskripsi" class="w-full border px-2 py-1 mb-2 rounded text-sm">{{ $item->deskripsi }}</textarea>

                                        @if ($item->file)
                                            <p class="mb-2 text-sm">
                                                File lama:
                                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                    class="text-blue-600 underline">Lihat File</a>
                                            </p>
                                        @endif

                                        <input type="file" name="file" class="mb-3 text-sm">

                                        <div class="flex justify-end space-x-2">
                                            <button type="button" @click="editId = null"
                                                class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-600 text-white rounded text-sm">Simpan</button>
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
            @include('components.pagination', ['data' => $dokumen_htn])
        </div>

        <!-- Modal Tambah -->
        <div x-show="openTambah" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
            <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                <h2 class="text-lg font-bold mb-4">Tambah Dokumen</h2>
                <form action="{{ route('dokumen_htn.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="judul_mou" placeholder="Judul MoU" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <input type="text" name="lembaga_mitra" placeholder="Lembaga Mitra" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <input type="text" name="nomor_mou" placeholder="Nomor MoU" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <input type="text" name="kategori" placeholder="Kategori" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border px-2 py-1 mb-2 rounded text-sm"></textarea>
                    <input type="file" name="file" required class="mb-3 text-sm">

                    <div class="flex justify-end space-x-2">
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
