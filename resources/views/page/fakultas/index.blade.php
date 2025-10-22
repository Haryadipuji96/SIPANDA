<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .swal2-popup.small-toast {
            font-size: 0.85rem !important;
            padding: 0.75rem 1rem !important;
            min-width: 220px !important;
        }

        /* Responsif tabel agar bisa scroll di HP */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    <div class="p-4 sm:p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2">
                    📂 Dokumen Fakultas Ekonomi
                </h1>
                <!-- Tombol Tambah -->
                <button @click="openTambah = true"
                    class="flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition duration-200 ease-in-out transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Dokumen</span>
                </button>
            </div>

            <!-- Tabel -->
            <div class="table-wrapper border border-gray-200 rounded-lg">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white text-left">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Fakultas</th>
                            <th class="px-4 py-2 border">Dekan</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">File</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fakultas as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                <td class="border px-4 py-2 text-center">{{ $fakultas->firstItem() + $index }}</td>
                                <td class="border px-4 py-2 font-semibold text-gray-700">{{ $item->nama_fakultas }}</td>
                                <td class="border px-4 py-2">{{ $item->dekan ?? '-' }}</td>
                                <td class="border px-4 py-2 text-gray-600">{{ $item->deskripsi ?? '-' }}</td>
                                <td class="border px-4 py-2 text-blue-600 text-sm">
                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                        class="underline hover:text-blue-800">Lihat File</a>
                                </td>
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
                                    <form action="{{ route('fakultas.destroy', $item->id) }}" method="POST"
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

                            <!-- Modal Edit -->
                            <div x-show="editId === {{ $item->id }}" x-cloak
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                                <div class="bg-white p-6 rounded-xl w-full max-w-md">
                                    <h2 class="text-lg font-bold mb-4">Edit Dokumen</h2>
                                    <form action="{{ route('fakultas.update', $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="nama_fakultas" value="{{ $item->nama_fakultas }}"
                                            required class="w-full border px-2 py-1 mb-2 rounded">
                                        <input type="text" name="dekan" value="{{ $item->dekan }}" required
                                            class="w-full border px-2 py-1 mb-2 rounded">
                                        <textarea name="deskripsi" class="w-full border px-2 py-1 mb-2 rounded">{{ $item->deskripsi }}</textarea>
                                        <input type="file" name="file"
                                            class="w-full border rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">

                                        @if ($item->file)
                                            <p class="mb-2 text-sm mt-2">
                                                File lama:
                                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                    class="text-blue-600 underline">Lihat File</a>
                                            </p>
                                        @endif
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" @click="editId = null"
                                                class="px-3 py-1 bg-gray-400 rounded">Batal</button>
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-600 text-white rounded">Simpan</button>
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

            <!-- Pagination -->
            @include('components.pagination', ['data' => $fakultas])

            <!-- Modal Tambah -->
            <div x-show="openTambah" x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                <div class="bg-white p-6 rounded-xl w-full max-w-md">
                    <h2 class="text-lg font-bold mb-4">Tambah Dokumen</h2>
                    <form action="{{ route('fakultas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="nama_fakultas" placeholder="Nama Fakultas" required
                            class="w-full border px-2 py-1 mb-2 rounded">
                        <input type="text" name="dekan" placeholder="Dekan" required
                            class="w-full border px-2 py-1 mb-2 rounded">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border px-2 py-1 mb-2 rounded"></textarea>
                        <input type="file" name="file" required
                            class="w-full border rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">

                        <div class="flex justify-end space-x-2 mt-3">
                            <button type="button" @click="openTambah = false"
                                class="px-3 py-1 bg-gray-400 rounded">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Simpan</button>
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
                background: '#f9fafb',
                color: '#1f2937',
                iconColor: '#22c55e',
                customClass: {
                    popup: 'small-toast shadow-lg rounded-xl border border-gray-200'
                }
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
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
</x-app-layout>
