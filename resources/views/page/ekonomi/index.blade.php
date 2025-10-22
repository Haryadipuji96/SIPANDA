<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Toast style */
        .swal2-popup.small-toast {
            font-size: 0.85rem !important;
            padding: 0.75rem 1rem !important;
            min-width: 220px !important;
        }

        /* Modal animation */
        .modal-overlay {
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <div class="p-4 sm:p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-4 sm:p-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 text-center sm:text-left">
                    📂 Dokumen Ekonomi Syariah
                </h1>
                <button @click="openTambah = true"
                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Dokumen</span>
                </button>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Judul</th>
                            <th class="px-4 py-2 border">Kategori</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">File</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                <td class="border px-4 py-2 text-center">
                                    {{ ($dokumen->currentPage() - 1) * $dokumen->perPage() + $loop->iteration }}
                                </td>

                                <td class="border px-4 py-2">{{ $item->judul }}</td>
                                <td class="border px-4 py-2">{{ $item->kategori ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->deskripsi ?? '-' }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                        class="text-blue-600 underline hover:text-blue-800 text-sm">
                                        Lihat File
                                    </a>
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
                                        <form action="{{ route('dokumen-ekonomi.destroy', $item) }}" method="POST"
                                            class="inline">
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
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay z-50">
                                <div
                                    class="bg-white p-6 rounded-lg w-full max-w-sm shadow-lg relative overflow-y-auto max-h-[90vh]">
                                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Edit Dokumen</h2>

                                    <form action="{{ route('dokumen-ekonomi.update', $item) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="space-y-3">
                                            <input type="text" name="judul" value="{{ $item->judul }}"
                                                placeholder="Judul Dokumen"
                                                class="w-full border rounded-md px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500"
                                                required>
                                            <input type="text" name="kategori" value="{{ $item->kategori }}"
                                                placeholder="Kategori"
                                                class="w-full border rounded-md px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500"
                                                required>
                                            <textarea name="deskripsi" rows="3" placeholder="Deskripsi"
                                                class="w-full border rounded-md px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">{{ $item->deskripsi }}</textarea>
                                            <input type="file" name="file"
                                                class="w-full border rounded-md px-3 py-2 text-sm">
                                            @if ($item->file)
                                                <p class="text-xs mt-1 text-blue-600 text-start">
                                                    File saat ini:
                                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                        class="underline hover:text-blue-800">Lihat</a>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex justify-end mt-5 gap-2">
                                            <button type="button" @click="editId = null"
                                                class="px-3 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md text-sm">Batal</button>
                                            <button type="submit"
                                                class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 bg-gray-50 text-gray-500">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('components.pagination', ['data' => $dokumen])

            <!-- Modal Tambah -->
            <div x-show="openTambah" x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay z-50">
                <div class="bg-white p-6 rounded-lg w-full max-w-sm shadow-lg relative">
                    <h2 class="text-lg font-bold mb-4 text-gray-700">Tambah Dokumen</h2>
                    <form action="{{ route('dokumen-ekonomi.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="judul" placeholder="Judul" required
                            class="w-full border px-3 py-2 mb-2 rounded-md">
                        <input type="text" name="kategori" placeholder="Kategori" required
                            class="w-full border px-3 py-2 mb-2 rounded-md">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border px-3 py-2 mb-2 rounded-md"></textarea>
                        <input type="file" name="file" required class="mb-3 text-sm">

                        <div class="flex justify-end gap-2 mt-2">
                            <button type="button" @click="openTambah = false"
                                class="px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded text-white text-sm">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
            });
        @endif

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
