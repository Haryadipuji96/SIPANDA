<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">📂 Dokumen HKI</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                    + Tambah Dokumen
                </button>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-2 border">Nama Dokumen Kegiatan</th>
                            <th class="px-4 py-2 border">Tahun</th>
                            <th class="px-4 py-2 border">Fakultas</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">File</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hki as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-4 py-2">{{ $item->nama_dokumen_kegiatan }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->tahun ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->fakultas ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->deskripsi ?? '-' }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                        class="text-blue-600 underline">Lihat</a>
                                </td>
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
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                                            <h2 class="text-lg font-bold mb-4">Edit Dokumen</h2>
                                            <form action="{{ route('hki.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <input type="text" name="nama_dokumen_kegiatan"
                                                    value="{{ $item->nama_dokumen_kegiatan }}" required
                                                    class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                                <input type="text" name="tahun" value="{{ $item->tahun }}"
                                                    required class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                                <input type="text" name="fakultas" value="{{ $item->fakultas }}"
                                                    required class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                                <textarea name="deskripsi" class="w-full border px-2 py-1 mb-2 rounded text-sm">{{ $item->deskripsi }}</textarea>
                                                <input type="file" name="file" class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                                @if ($item->file)
                                                    <p class="mb-2 text-start mt-2">
                                                        File lama:
                                                        <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                            class="text-blue-600 underline">Lihat File</a>
                                                    </p>
                                                @endif
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" @click="editId = null"
                                                        class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-green-600 text-white rounded text-sm">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('hki.destroy', $item->id) }}" method="POST" class="inline">
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
                                <td colspan="6" class="text-center py-4 text-gray-500 bg-gray-50">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div x-show="openTambah" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                <h2 class="text-lg font-bold mb-4">Tambah Dokumen</h2>
                <form action="{{ route('hki.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="nama_dokumen_kegiatan" placeholder="Nama Dokumen Kegiatan" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <input type="text" name="tahun" placeholder="Tahun" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <input type="text" name="fakultas" placeholder="Fakultas" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border px-2 py-1 mb-2 rounded text-sm"></textarea>
                    <input type="file" name="file" required class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                    <div class="flex justify-end space-x-2 mt-3">
                        <button type="button" @click="openTambah = false"
                            class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                        <button type="submit"
                            class="px-3 py-1 bg-green-600 text-white rounded text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
