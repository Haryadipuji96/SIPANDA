<x-app-layout>
    <div class="p-6" x-data="{ openTambah: false, openEdit: null }">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">📁 Dokumen Dosen</h1>
            <button @click="openTambah = true"
                class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">
                + Tambah Dokumen
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama Dosen</th>
                        <th class="px-4 py-2 text-left">Kategori</th>
                        <th class="px-4 py-2 text-left">Nama Dokumen</th>
                        <th class="px-4 py-2 text-left">Tanggal Upload</th>
                        <th class="px-4 py-2 text-left">Keterangan</th>
                        <th class="px-4 py-2 text-left">File</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($dokumen as $index => $item)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->dosen->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->nama_dokumen }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                    class="text-blue-500 hover:underline">Lihat File</a>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button @click="openEdit = {{ $item->id }}"
                                    class="bg-yellow-400 text-white px-3 py-1 rounded-md hover:bg-yellow-500">Edit</button>
                                <form action="{{ route('dokumen-dosen.destroy', $item->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600"
                                        onclick="return confirm('Yakin ingin menghapus dokumen ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div x-show="openEdit === {{ $item->id }}"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                                <h2 class="text-xl font-semibold mb-4">Edit Dokumen</h2>
                                <form action="{{ route('dokumen-dosen.update', $item->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="block mb-1 text-sm">Nama Dosen</label>
                                        <select name="dosen_id" class="w-full border-gray-300 rounded-lg">
                                            @foreach ($dosens as $dosen)
                                                <option value="{{ $dosen->id }}"
                                                    {{ $item->dosen_id == $dosen->id ? 'selected' : '' }}>
                                                    {{ $dosen->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block mb-1 text-sm">Kategori</label>
                                        <select name="kategori_id" class="w-full border-gray-300 rounded-lg">
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"
                                                    {{ $item->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block mb-1 text-sm">Nama Dokumen</label>
                                        <input type="text" name="nama_dokumen" value="{{ $item->nama_dokumen }}"
                                            class="w-full border-gray-300 rounded-lg" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="block mb-1 text-sm">File (optional)</label>
                                        <input type="file" name="file_path" class="w-full border-gray-300 rounded-lg">
                                    </div>

                                    <div class="mb-3">
                                        <label class="block mb-1 text-sm">Keterangan</label>
                                        <textarea name="keterangan" class="w-full border-gray-300 rounded-lg">{{ $item->keterangan }}</textarea>
                                    </div>

                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" @click="openEdit = null"
                                            class="bg-gray-400 text-white px-4 py-2 rounded-lg">Batal</button>
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah -->
        <div x-show="openTambah"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <h2 class="text-xl font-semibold mb-4">Tambah Dokumen Dosen</h2>
                <form action="{{ route('dokumen-dosen.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="block mb-1 text-sm">Nama Dosen</label>
                        <select name="dosen_id" class="w-full border-gray-300 rounded-lg" required>
                            <option value="">-- Pilih Dosen --</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1 text-sm">Kategori</label>
                        <select name="kategori_id" class="w-full border-gray-300 rounded-lg" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1 text-sm">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1 text-sm">File Dokumen</label>
                        <input type="file" name="file_path" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-3">
                        <label class="block mb-1 text-sm">Keterangan</label>
                        <textarea name="keterangan" class="w-full border-gray-300 rounded-lg"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="openTambah = false"
                            class="bg-gray-400 text-white px-4 py-2 rounded-lg">Batal</button>
                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
