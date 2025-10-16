<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Data Sarana & Prasarana</h1>
                <button @click="openTambah = true"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">+ Tambah
                    Data</button>
            </div>

            {{-- Pesan sukses --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel Data --}}
            <div id="table-wrapper" class="overflow-x-auto border rounded-lg">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-3 py-2 border">No</th>
                            <th class="px-3 py-2 border">Nama Barang</th>
                            <th class="px-3 py-2 border">Kategori</th>
                            <th class="px-3 py-2 border">Lokasi</th>
                            <th class="px-3 py-2 border">Jumlah</th>
                            <th class="px-3 py-2 border">Kondisi</th>
                            <th class="px-3 py-2 border">Tanggal PengadaZan</th>
                            <th class="px-3 py-2 border">Keterangan</th>
                            <th class="px-3 py-2 border">File Dokumen</th>
                            <th class="px-3 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_sarpras as $index => $item)
                             <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border px-3 py-2">{{ $item->nama_barang }}</td>
                                <td class="border px-3 py-2">{{ $item->kategori }}</td>
                                <td class="border px-3 py-2">{{ $item->lokasi }}</td>
                                <td class="border px-3 py-2 text-center">{{ $item->jumlah }}</td>
                                <td class="border px-3 py-2">{{ $item->kondisi }}</td>
                                <td class="border px-3 py-2">{{ $item->tanggal_pengadaan }}</td>
                                <td class="border px-3 py-2">{{ $item->keterangan }}</td>
                                <td class="border px-3 py-2 text-center">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="text-blue-600 hover:underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="border px-3 py-2 text-center space-x-2">
                                    <button @click="editId = {{ $item->id }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('data_sarpras.destroy', $item->id) }}" method="POST"
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
                                <td colspan="10" class="text-center py-3 text-gray-500">Belum ada data sarpras</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah Data --}}
        <div x-show="openTambah" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
                <h2 class="text-lg font-semibold mb-4">Tambah Data Sarpras</h2>

                <form action="{{ route('data_sarpras.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="text" name="nama_barang" placeholder="Nama Barang" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">

                    <select name="kategori" required class="w-full border px-2 py-1 mb-2 rounded text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Sarana">Sarana</option>
                        <option value="Prasarana">Prasarana</option>
                    </select>

                    <input type="text" name="lokasi" placeholder="Lokasi"
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">

                    <input type="number" name="jumlah" placeholder="Jumlah" min="1"
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">

                    <select name="kondisi" required class="w-full border px-2 py-1 mb-2 rounded text-sm">
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                        <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                    </select>

                    <input type="date" name="tanggal_pengadaan" class="w-full border px-2 py-1 mb-2 rounded text-sm">

                    <textarea name="keterangan" placeholder="Keterangan" class="w-full border px-2 py-1 mb-2 rounded text-sm"></textarea>

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

        {{-- Modal Edit Data --}}
        @foreach ($data_sarpras as $edit)
            <div x-show="editId === {{ $edit->id }}" x-cloak
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
                    <h2 class="text-lg font-semibold mb-4">Edit Data Sarpras</h2>

                    <form action="{{ route('data_sarpras.update', $edit->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="text" name="nama_barang" value="{{ $edit->nama_barang }}" required
                            class="w-full border px-2 py-1 mb-2 rounded text-sm">

                        <select name="kategori" required class="w-full border px-2 py-1 mb-2 rounded text-sm">
                            <option value="Sarana" {{ $edit->kategori == 'Sarana' ? 'selected' : '' }}>Sarana</option>
                            <option value="Prasarana" {{ $edit->kategori == 'Prasarana' ? 'selected' : '' }}>Prasarana
                            </option>
                        </select>

                        <input type="text" name="lokasi" value="{{ $edit->lokasi }}"
                            class="w-full border px-2 py-1 mb-2 rounded text-sm">

                        <input type="number" name="jumlah" value="{{ $edit->jumlah }}" min="1"
                            class="w-full border px-2 py-1 mb-2 rounded text-sm">

                        <select name="kondisi" required class="w-full border px-2 py-1 mb-2 rounded text-sm">
                            <option value="Baik" {{ $edit->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ $edit->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>
                                Rusak Ringan</option>
                            <option value="Rusak Berat" {{ $edit->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak
                                Berat</option>
                            <option value="Perlu Perbaikan"
                                {{ $edit->kondisi == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                        </select>

                        <input type="date" name="tanggal_pengadaan" value="{{ $edit->tanggal_pengadaan }}"
                            class="w-full border px-2 py-1 mb-2 rounded text-sm">

                        <textarea name="keterangan" class="w-full border px-2 py-1 mb-2 rounded text-sm">{{ $edit->keterangan }}</textarea>

                        <input type="file" name="file_dokumen" class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @if ($edit->file_dokumen)
                            <p class="text-xs mb-2 mt-2">File lama:
                                <a href="{{ asset('storage/' . $edit->file_dokumen) }}" target="_blank"
                                    class="text-blue-600 hover:underline">Lihat Dokumen</a>
                            </p>
                        @endif

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="editId = null"
                                class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                            <button type="submit"
                                class="px-3 py-1 bg-green-600 text-white rounded text-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>
