<x-app-layout>
    {{-- ✅ Pastikan elemen dengan x-cloak benar-benar disembunyikan sebelum Alpine aktif --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">📂 Dokumen Ekonomi Syariah</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                    + Tambah Dokumen
                </button>
            </div>

            <!-- ✅ Tabel Data -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-2 border">Judul</th>
                            <th class="px-4 py-2 border">Kategori</th>
                            <th class="px-4 py-2 border">File</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-4 py-2">{{ $item->judul }}</td>
                                <td class="border px-4 py-2">{{ $item->kategori ?? '-' }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                        class="text-blue-600 underline">Lihat File</a>
                                </td>
                                <td class="border px-4 py-2 space-x-2 text-center">
                                    <!-- Tombol Edit -->
                                    <button @click="editId = {{ $item->id }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <!-- ✅ Modal Edit -->
                                    <div x-show="editId === {{ $item->id }}" x-cloak
                                        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                                        <div
                                            class="bg-white p-5 rounded-2xl shadow-xl w-full max-w-md transition transform scale-100">
                                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Edit Dokumen</h2>

                                            <form action="{{ route('dokumen-ekonomi.update', $item) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="space-y-3">
                                                    <input type="text" name="judul" value="{{ $item->judul }}"
                                                        placeholder="Judul Dokumen"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500"
                                                        required>

                                                    <input type="text" name="kategori" value="{{ $item->kategori }}"
                                                        placeholder="Kategori"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500"
                                                        required>

                                                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">{{ $item->deskripsi }}</textarea>

                                                    <input type="file" name="file"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                                    @if ($item->file)
                                                        <div class="text-xs mt-1 text-blue-600 text-start">
                                                            File saat ini:
                                                            <a href="{{ asset('storage/' . $item->file) }}"
                                                                target="_blank" class="underline hover:text-blue-800">
                                                                Lihat
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex justify-end mt-5 space-x-2">
                                                    <button type="button" @click="editId = null"
                                                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md text-sm">Batal</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('dokumen-ekonomi.destroy', $item) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus dokumen ini?')"
                                            class="text-red-600 hover:text-red-700 transition">
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
                                <td colspan="4" class="text-center py-3 bg-gray-50 text-gray-500">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ✅ Modal Tambah Dokumen -->
            <div x-show="openTambah" x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                    <h2 class="text-lg font-bold mb-4">Tambah Dokumen</h2>
                    <form action="{{ route('dokumen-ekonomi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="judul" placeholder="Judul" required
                            class="w-full border px-2 py-1 mb-2 rounded">
                        <input type="text" name="kategori" placeholder="Kategori" required
                            class="w-full border px-2 py-1 mb-2 rounded">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border px-2 py-1 mb-2 rounded"></textarea>
                        <input type="file" name="file" required class="mb-2 text-sm">

                        <div class="flex justify-end space-x-2 mt-2">
                            <button type="button" @click="openTambah = false"
                                class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                            <button type="submit"
                                class="px-3 py-1 bg-green-600 text-white rounded text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
