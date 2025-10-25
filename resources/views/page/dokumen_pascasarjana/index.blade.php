<x-app-layout>
    @php
        $highlight = request('highlight'); // ambil dari query string ?highlight=...
    @endphp
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

        /* ubah warna centang jadi hijau */
        input[type="checkbox"]:checked {
            accent-color: #16a34a;
            /* green-600 */
        }

        /* kalau accent-color gak didukung browser */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* checkbox biar gak ganggu */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* 🔥 Efek highlight cepat (1 detik, pudar halus) */
        @keyframes fadeHighlight {
            0% {
                background-color: #fde68a;
                /* kuning terang */
            }

            70% {
                background-color: #fef3c7;
                /* kuning lembut */
            }

            100% {
                background-color: transparent;
            }
        }

        .fade-once {
            animation: fadeHighlight 5s ease-out forwards;
            /* 1 detik aja */
        }
    </style>

    <!-- NOTE: dokumen dimasukkan ke x-data utama supaya tombol Edit dan modal share state -->
    <div class="p-4 md:p-6" x-data="{ openTambah: false, editId: null, dokumen: {{ Js::from($dokumen_pascasarjana) }} }">
        <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-md p-4 md:p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2">
                    📂 Dokumen MoU Institut Pascasarjana</h1>
                <button @click="openTambah = true"
                    class="flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition duration-200 ease-in-out transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Dokumen
                </button>
            </div>

            <form id="bulkDeleteForm" action="{{ route('dokumen_pascasarjana.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-between items-center mb-2">
                    <button type="submit"
                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 disabled:opacity-50"
                        id="deleteSelected" disabled>
                        Hapus Terpilih
                    </button>
                </div>


                <!-- Tabel Responsif -->
                <div class="table-wrapper border border-gray-200 rounded-lg">
                    <table class="min-w-full table-auto text-sm border-collapse">
                        <thead class="bg-green-600 text-white text-left">
                            <tr>
                                <th class="px-4 py-2 border text-center">
                                    <input type="checkbox" id="selectAll"
                                        class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                </th>
                                <th class="px-4 py-2 border">Judul MoU</th>
                                <th class="px-4 py-2 border">Judul MoU</th>
                                <th class="px-4 py-2 border">Nomor MoU</th>
                                <th class="px-4 py-2 border">Lembaga Mitra</th>
                                <th class="px-4 py-2 border">Jenis Kerjasama</th>
                                <th class="px-4 py-2 border">Tingkat Kerjasama</th>
                                <th class="px-4 py-2 border">Tanggal TTD</th>
                                <th class="px-4 py-2 border">Masa Berlaku</th>
                                <th class="px-4 py-2 border">Penanggung Jawab</th>
                                <th class="px-4 py-2 border">Program Studi</th>
                                <th class="px-4 py-2 border">Jenis Kegiatan</th>
                                <th class="px-4 py-2 border">Keterangan</th>
                                <th class="px-4 py-2 border text-center">File</th>
                                <th class="px-4 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dokumen_pascasarjana as $index => $item)
                                <tr id="row-{{ $item->id }}"
                                    class="
                                    {{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}
                                    {{ $highlight &&
                                    (str_contains(strtolower($item->judul_mou), strtolower($highlight)) ||
                                        str_contains(strtolower($item->nomor_mou ?? ''), strtolower($highlight)) ||
                                        str_contains(strtolower($item->lembaga_mitra ?? ''), strtolower($highlight)))
                                        ? 'fade-once'
                                        : '' }} ">
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $dokumen_pascasarjana->firstItem() + $index }}</td>
                                    <td class="border px-4 py-2">{{ $item->judul_mou }}</td>
                                    <td class="border px-4 py-2">{{ $item->nomor_mou ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->lembaga_mitra ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->jenis_kerjasama ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->tingkat_kerjasama ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->tanggal_ttd ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->masa_berlaku ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->penanggung_jawab ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->program_studi ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->jenis_kegiatan ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>

                                    <!-- File -->
                                    <td class="border px-4 py-2 text-center">
                                        @if ($item->file_dokumen)
                                            <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 transition underline">Lihat</a>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <!-- Edit -->
                                            <button type="button" @click="editId = {{ $item->id }}"
                                                class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>

                                            <!-- Hapus -->
                                            <form action="{{ route('dokumen_pascasarjana.destroy', $item) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn-hapus p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
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
                                    <div
                                        class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                                        <!-- Header -->
                                        <div
                                            class="bg-green-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                                            <h2 class="text-lg font-semibold">Edit Dokumen Pascasarjana</h2>
                                            <button type="button" @click="editId = null"
                                                class="text-white text-2xl font-semibold hover:text-gray-200 transition">&times;</button>
                                        </div>

                                        <!-- Form -->
                                        <form action="{{ route('dokumen_pascasarjana.update', $item->id) }}"
                                            method="POST" enctype="multipart/form-data" class="p-5 space-y-5">
                                            @csrf
                                            @method('PUT')

                                            <!-- Grid 2 Kolom -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-6">
                                                <!-- Kolom Kiri -->
                                                <div class="space-y-4">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Judul
                                                            MoU *</label>
                                                        <input type="text" name="judul_mou"
                                                            value="{{ $item->judul_mou }}" required
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Nomor
                                                            MoU</label>
                                                        <input type="text" name="nomor_mou"
                                                            value="{{ $item->nomor_mou }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Lembaga
                                                            Mitra</label>
                                                        <input type="text" name="lembaga_mitra"
                                                            value="{{ $item->lembaga_mitra }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                                            Kerjasama</label>
                                                        <input type="text" name="jenis_kerjasama"
                                                            value="{{ $item->jenis_kerjasama }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Tingkat
                                                            Kerjasama</label>
                                                        <input type="text" name="tingkat_kerjasama"
                                                            value="{{ $item->tingkat_kerjasama }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Penanggung
                                                            Jawab</label>
                                                        <input type="text" name="penanggung_jawab"
                                                            value="{{ $item->penanggung_jawab }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>
                                                </div>

                                                <!-- Kolom Kanan -->
                                                <div class="space-y-4">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                                            TTD</label>
                                                        <input type="date" name="tanggal_ttd"
                                                            value="{{ $item->tanggal_ttd }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Masa
                                                            Berlaku</label>
                                                        <input type="text" name="masa_berlaku"
                                                            value="{{ $item->masa_berlaku }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Program
                                                            Studi</label>
                                                        <input type="text" name="program_studi"
                                                            value="{{ $item->program_studi }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Jenis
                                                            Kegiatan</label>
                                                        <input type="text" name="jenis_kegiatan"
                                                            value="{{ $item->jenis_kegiatan }}"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Upload
                                                            File Dokumen</label>
                                                        <input type="file" name="file_dokumen"
                                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                        <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX,
                                                            JPG,
                                                            PNG (Maks. 5MB)</p>

                                                        @if ($item->file_dokumen)
                                                            <div class="text-xs mt-1 text-blue-600">
                                                                <span>File saat ini:</span>
                                                                <a href="{{ asset('storage/' . $item->file_dokumen) }}"
                                                                    target="_blank" class="underline">Lihat</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="grid-cols-1 md:grid-cols-2 gap-4 px-6">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                                <textarea name="keterangan" rows="3"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $item->keterangan }}</textarea>
                                            </div>

                                            <!-- Tombol Aksi -->
                                            <div class="flex justify-end mt-6 space-x-3 pb-6 px-6">
                                                <button type="button" @click="editId = null"
                                                    class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                                                    Update Dokumen
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
                @include('components.pagination', ['data' => $dokumen_pascasarjana])
        </div>

        <!-- Modal Tambah -->
        <div x-show="openTambah" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="bg-green-600 text-white p-4 rounded-t-lg">
                    <h2 class="text-lg font-semibold">Tambah Dokumen MoU</h2>
                </div>

                <form action="{{ route('dokumen_pascasarjana.store') }}" method="POST"
                    enctype="multipart/form-data" class="p-5">
                    @csrf

                    <!-- Grid 2 kolom -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul MoU *</label>
                                <input type="text" name="judul_mou" placeholder="Masukkan judul MoU" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor MoU</label>
                                <input type="text" name="nomor_mou" placeholder="Masukkan nomor MoU"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lembaga Mitra</label>
                                <input type="text" name="lembaga_mitra" placeholder="Masukkan nama lembaga mitra"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kerjasama</label>
                                <input type="text" name="jenis_kerjasama" placeholder="Masukkan jenis kerjasama"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Kerjasama</label>
                                <input type="text" name="tingkat_kerjasama"
                                    placeholder="Masukkan tingkat kerjasama"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab</label>
                                <input type="text" name="penanggung_jawab" placeholder="Masukkan penanggung jawab"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal TTD</label>
                                <input type="date" name="tanggal_ttd"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku</label>
                                <input type="text" name="masa_berlaku" placeholder="Contoh: 3 tahun"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                <input type="text" name="program_studi" placeholder="Masukkan program studi"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kegiatan</label>
                                <input type="text" name="jenis_kegiatan" placeholder="Masukkan jenis kegiatan"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Dokumen</label>
                                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Maks. 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan (full width) -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" placeholder="Masukkan keterangan tambahan" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" @click="openTambah = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                            Simpan Dokumen
                        </button>
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

    <script>
        // 🔹 SweetAlert untuk hapus banyak data (checkbox)
        const bulkForm = document.getElementById('bulkDeleteForm');
        const bulkDeleteBtn = document.getElementById('deleteSelected');

        if (bulkForm && bulkDeleteBtn) {
            bulkForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const checked = document.querySelectorAll('.select-item:checked');
                if (checked.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Belum ada data yang dipilih',
                        text: 'Silakan centang data yang ingin dihapus.',
                        confirmButtonColor: '#22c55e',
                        background: '#f9fafb',
                        color: '#1f2937',
                        iconColor: '#22c55e',
                    });
                    return;
                }

                Swal.fire({
                    title: `Yakin ingin menghapus ${checked.length} data terpilih?`,
                    text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    background: '#f9fafb',
                    color: '#1f2937',
                    iconColor: '#ef4444',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkForm.submit();
                    }
                });
            });
        }
    </script>

    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.select-item');
        const deleteBtn = document.getElementById('deleteSelected');

        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            toggleDeleteButton();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', toggleDeleteButton));

        function toggleDeleteButton() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            deleteBtn.disabled = !anyChecked;
        }
    </script>
    @if (request()->has('highlight_id'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const row = document.getElementById('row-{{ request('highlight_id') }}');
                if (row) {
                    row.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    // Tambahkan efek highlight agar lebih jelas
                    row.classList.add('fade-once');
                }
            });
        </script>
    @endif
</x-app-layout>
