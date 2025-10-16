<x-app-layout>
    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-700">📜 Dokumen Peraturan</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm transition">
                    + Tambah Data
                </button>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="w-full overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full table-auto text-sm border-collapse">
                    <thead class="bg-green-600 text-white text-left">
                        <tr>
                            <th class="border px-3 py-2">No</th>
                            <th class="border px-3 py-2">Judul</th>
                            <th class="border px-3 py-2">Nomor Peraturan</th>
                            <th class="border px-3 py-2">Kategori</th>
                            <th class="border px-3 py-2">Tanggal Terbit</th>
                            <th class="border px-3 py-2">Keterangan</th>
                            <th class="border px-3 py-2 text-center">File</th>
                            <th class="border px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dokumen_peraturan as $index => $item)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $item->judul }}</td>
                                <td class="border px-4 py-2">{{ $item->nomor_peraturan ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->kategori ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->tanggal_terbit ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>

                                {{-- File --}}
                                <td class="border px-4 py-2 text-center">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="text-blue-600 underline hover:text-blue-800">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="border px-4 py-2 text-center space-x-2">
                                    {{-- Tombol Edit --}}
                                    <button @click="editId = {{ $item->id }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    {{-- Modal Edit --}}
                                    <div x-show="editId === {{ $item->id }}" x-cloak
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                                            <h2 class="text-lg font-bold mb-4 text-gray-700">Edit Dokumen</h2>

                                            <form action="{{ route('dokumen_peraturan.update', $item->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="space-y-2 text-sm">
                                                    <input type="text" name="judul" value="{{ $item->judul }}"
                                                        placeholder="Judul" required
                                                        class="w-full border px-2 py-1 rounded">

                                                    <input type="text" name="nomor_peraturan"
                                                        value="{{ $item->nomor_peraturan }}"
                                                        placeholder="Nomor Peraturan"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <select name="kategori" class="w-full border px-2 py-1 rounded">
                                                        <option value="Akademik"
                                                            {{ $item->kategori == 'Akademik' ? 'selected' : '' }}>
                                                            Akademik</option>
                                                        <option value="Kepegawaian"
                                                            {{ $item->kategori == 'Kepegawaian' ? 'selected' : '' }}>
                                                            Kepegawaian</option>
                                                        <option value="Kemahasiswaan"
                                                            {{ $item->kategori == 'Kemahasiswaan' ? 'selected' : '' }}>
                                                            Kemahasiswaan</option>
                                                        <option value="Umum"
                                                            {{ $item->kategori == 'Umum' ? 'selected' : '' }}>Umum
                                                        </option>
                                                        <option value="Lainnya"
                                                            {{ $item->kategori == 'Lainnya' ? 'selected' : '' }}>
                                                            Lainnya</option>
                                                    </select>

                                                    <input type="date" name="tanggal_terbit"
                                                        value="{{ $item->tanggal_terbit }}"
                                                        class="w-full border px-2 py-1 rounded">

                                                    <textarea name="keterangan" placeholder="Keterangan" class="w-full border px-2 py-1 rounded">{{ $item->keterangan }}</textarea>
                                                    <input type="file" name="file_dokumen"
                                                        class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                                    @if ($item->file_dokumen)
                                                        <p class="text-sm text-start">
                                                            File lama:
                                                            <a href="{{ asset('storage/' . $item->file_dokumen) }}"
                                                                target="_blank"
                                                                class="text-blue-600 underline hover:text-blue-800">Lihat</a>
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

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('dokumen_peraturan.destroy', $item->id) }}" method="POST"
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
                                <td colspan="8" class="text-center py-4 text-gray-500 bg-gray-50">
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div x-show="openTambah" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                <h2 class="text-lg font-bold mb-4 text-gray-700">Tambah Dokumen Peraturan</h2>

                <form action="{{ route('dokumen_peraturan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="text" name="judul" placeholder="Judul Peraturan" required
                        class="w-full border px-3 py-2 mb-2 rounded text-sm">

                    <input type="text" name="nomor_peraturan" placeholder="Nomor Peraturan"
                        class="w-full border px-3 py-2 mb-2 rounded text-sm">

                    {{-- Dropdown kategori --}}
                    <select name="kategori" class="w-full border px-3 py-2 mb-2 rounded text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Kepegawaian">Kepegawaian</option>
                        <option value="Kemahasiswaan">Kemahasiswaan</option>
                        <option value="Umum">Umum</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>

                    <input type="date" name="tanggal_terbit" class="w-full border px-3 py-2 mb-2 rounded text-sm">

                    <textarea name="keterangan" placeholder="Keterangan" class="w-full border px-3 py-2 mb-2 rounded text-sm"></textarea>

                    <input type="file" name="file_dokumen" class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

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
