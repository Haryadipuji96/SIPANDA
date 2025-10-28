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

        /* From Uiverse.io by andrew-demchenk0 */
        .button {
            position: relative;
            width: 160px;
            height: 42px;
            cursor: pointer;
            display: flex;
            align-items: center;
            border: 1px solid #34974d;
            background-color: #3aa856;
            overflow: hidden;
            border-radius: 8px;
        }

        .button,
        .button__icon,
        .button__text {
            transition: all 0.3s ease;
        }

        .button .button__text {
            transform: translateX(30px);
            color: #fff;
            font-weight: 600;
        }

        .button .button__icon {
            position: absolute;
            transform: translateX(110px);
            height: 100%;
            width: 40px;
            background-color: #34974d;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .button .svg {
            width: 24px;
            stroke: #fff;
        }

        .button:hover {
            background: #34974d;
        }

        .button:hover .button__text {
            color: transparent;
        }

        .button:hover .button__icon {
            width: 100%;
            transform: translateX(0);
        }

        .button:active .button__icon {
            background-color: #2e8644;
        }

        .button:active {
            border: 1px solid #2e8644;
        }
    </style>
    <div class="p-6" x-data="{ openTambah: false, editId: null }" x-cloak>
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 text-center sm:text-left">
                    Data Dosen
                </h1>
                @canAdmin
                <button type="button" @click="openTambah = true" class="button">
                    <span class="button__text">Add Data</span>
                    <span class="button__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="svg">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </span>
                </button>
                @endcanAdmin
            </div>

            <form id="bulkDeleteForm" action="{{ route('dokumen-dosen.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')
                @canAdmin
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-bold text-lg flex items-center gap-2 text-gray-700">
                        <i class="fa-solid fa-table-list"></i>
                    </h2>
                    <button type="submit" id="deleteSelected" disabled
                        class="group relative flex h-14 w-14 flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-red-800 bg-red-400 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed transition">
                        <!-- Spinner icon -->
                        <svg viewBox="0 0 1.625 1.625"
                            class="absolute -top-7 fill-white delay-100 group-hover:top-6 group-hover:animate-[spin_1.4s_linear] group-hover:duration-1000"
                            height="15" width="15">
                            <path
                                d="M.471 1.024v-.52a.1.1 0 0 0-.098.098v.618c0 .054.044.098.098.098h.487a.1.1 0 0 0 .098-.099h-.39c-.107 0-.195 0-.195-.195">
                            </path>
                            <path
                                d="M1.219.601h-.163A.1.1 0 0 1 .959.504V.341A.033.033 0 0 0 .926.309h-.26a.1.1 0 0 0-.098.098v.618c0 .054.044.098.098.098h.487a.1.1 0 0 0 .098-.099v-.39a.033.033 0 0 0-.032-.033">
                            </path>
                            <path
                                d="m1.245.465-.15-.15a.02.02 0 0 0-.016-.006.023.023 0 0 0-.023.022v.108c0 .036.029.065.065.065h.107a.023.023 0 0 0 .023-.023.02.02 0 0 0-.007-.016">
                            </path>
                        </svg>

                        <!-- Horizontal line (animate on hover) -->
                        <svg width="16" fill="none" viewBox="0 0 39 7"
                            class="origin-right duration-500 group-hover:rotate-90">
                            <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                            <line stroke-width="3" stroke="white" y2="1.5" x2="26.0357" y1="1.5"
                                x1="12"></line>
                        </svg>

                        <!-- Trash icon -->
                        <svg width="16" fill="none" viewBox="0 0 33 39">
                            <mask fill="white" id="path-1-inside-1_8_19">
                                <path d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"></path>
                            </mask>
                            <path mask="url(#path-1-inside-1_8_19)" fill="white"
                                d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z">
                            </path>
                            <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                            <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                        </svg>
                    </button>
                </div>
                @endcanAdmin
                <!-- ✅ Tabel -->
                <div class="table-wrapper border border-gray-200 rounded-lg overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-green-600 text-white">
                            <tr>
                                @canAdmin
                                <th rowspan="2" class="px-4 py-2 border text-center w-12">
                                    <input type="checkbox" id="selectAll"
                                        class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                </th>
                                @endcanAdmin

                                <th rowspan="2" class="px-4 py-2 border text-center w-12">No</th>
                                <th rowspan="2" class="border px-4 py-2">Nama</th>
                                <th rowspan="2" class="border px-4 py-2">Tempat Lahir</th>
                                <th rowspan="2" class="border px-4 py-2">NIK</th>
                                <th rowspan="2" class="border px-4 py-2">Pendidikan Terakhir</th>
                                <th rowspan="2" class="border px-4 py-2">Jabatan</th>
                                <th rowspan="2" class="border px-4 py-2">TMT Kerja</th>
                                <th colspan="2" class="border px-4 py-2">Masa Kerja</th>
                                <th rowspan="2" class="border px-4 py-2">Golongan</th>
                                <th colspan="2" class="border px-4 py-2">Masa Kerja Golongan</th>
                                <th rowspan="2" class="border px-4 py-2">File Dokumen</th>
                                <th rowspan="2" class="border px-4 py-2">Aksi</th>
                            </tr>

                            <!-- Baris 2 (subheader) -->
                            <tr>
                                <th class="border px-2 py-1">Thn</th>
                                <th class="border px-2 py-1">Bln</th>
                                <th class="border px-2 py-1">Thn</th>
                                <th class="border px-2 py-1">Bln</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($dokumen_dosen as $index => $item)
                                <tr id="row-{{ $item->id }}"
                                    class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }} 
                                    {{ $highlight &&
                                    (str_contains(strtolower($item->nama ?? ''), strtolower($highlight)) ||
                                        str_contains(strtolower($item->nik ?? ''), strtolower($highlight)))
                                        ? 'fade-once'
                                        : '' }}">

                                    @canAdmin
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm 
                   checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                    </td>
                                    @endcanAdmin

                                    <!-- No -->
                                    <td class="border px-4 py-2 text-center">{{ $dokumen_dosen->firstItem() + $index }}
                                    </td>

                                    <!-- Data Umum -->
                                    <td class="border px-4 py-2">{{ $item->nama ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->tempat_lahir ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->nik ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->pendidikan_terakhir ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->jabatan ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->tmt_kerja ?? '-' }}</td>

                                    <!-- Masa Kerja -->
                                    <td class="border px-4 py-2 text-center">{{ $item->masa_kerja_tahun ?? 0 }}</td>
                                    <td class="border px-4 py-2 text-center">{{ $item->masa_kerja_bulan ?? 0 }}</td>

                                    <!-- Golongan -->
                                    <td class="border px-4 py-2 text-center">{{ $item->golongan ?? '-' }}</td>

                                    <!-- Masa Kerja Golongan -->
                                    <td class="border px-4 py-2 text-center">
                                        {{ $item->masa_kerja_golongan_tahun ?? 0 }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $item->masa_kerja_golongan_bulan ?? 0 }}</td>

                                    <!-- File Dokumen -->
                                    <td class="border px-4 py-2 text-center">
                                        @if ($item->file_dokumen)
                                            <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-800 underline">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('dokumen-dosen.show', $item->id) }}"
                                                class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full transition"
                                                title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943
                           9.542 7-1.274 4.057-5.065 7-9.542 7-4.477
                           0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @canAdmin
                                            <!-- Edit -->
                                            <button type="button" @click="editId = {{ $item->id }}"
                                                class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2
                           0 002-2v-5M18.5 2.5a2.121 2.121
                           0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>

                                            <!-- Hapus -->
                                            <form action="{{ route('dokumen-dosen.destroy', $item) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn-hapus p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-full transition"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0
                               0116.138 21H7.862a2 2 0
                               01-1.995-1.858L5 7m5
                               4v6m4-6v6M9 7V4h6v3m-9
                               0h12" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endcanAdmin
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ request()->user()->can('admin') ? 13 : 12 }}"
                                        class="border px-4 py-6 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-12 h-12 text-gray-400 mb-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-lg font-medium">Tidak ada data dosen</p>
                                            <p class="text-sm">Data dosen akan muncul di sini setelah ditambahkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @include('components.pagination', ['data' => $dokumen_dosen])

                <!-- Modal Edit Data Dosen -->
                    <div x-show="editId === {{ $item->id }}" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[9999]">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto p-5">

                            <!-- Header -->
                            <div class="bg-green-600 text-white p-4 rounded-t-lg">
                                <h2 class="text-lg font-semibold">Edit Data Dosen</h2>
                            </div>

                            <form action="{{ route('dokumen-dosen.update', $item->id) }}" method="POST"
                                enctype="multipart/form-data" class="mt-4">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Kolom Kiri -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                                            <input type="text" name="nama" value="{{ $item->nama }}"
                                                required placeholder="Masukkan nama dosen"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                                            <input type="text" name="nik" value="{{ $item->nik }}"
                                                required placeholder="Masukkan NIK"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat
                                                Lahir</label>
                                            <input type="text" name="tempat_lahir"
                                                value="{{ $item->tempat_lahir }}" placeholder="Masukkan tempat lahir"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                                Lahir</label>
                                            <input type="date" name="tanggal_lahir"
                                                value="{{ $item->tanggal_lahir }}"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan
                                                Terakhir</label>
                                            <input type="text" name="pendidikan_terakhir"
                                                value="{{ $item->pendidikan_terakhir }}" placeholder="Contoh: S2, S3"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                            <input type="text" name="jabatan" value="{{ $item->jabatan }}"
                                                placeholder="Masukkan jabatan dosen"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">TMT
                                                Kerja</label>
                                            <input type="date" name="tmt_kerja" value="{{ $item->tmt_kerja }}"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">Golongan</label>
                                            <input type="text" name="golongan" value="{{ $item->golongan }}"
                                                placeholder="Masukkan golongan dosen"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Masa
                                                Kerja</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="number" name="masa_kerja_tahun"
                                                    value="{{ $item->masa_kerja_tahun }}" placeholder="Tahun"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                <input type="number" name="masa_kerja_bulan"
                                                    value="{{ $item->masa_kerja_bulan }}" placeholder="Bulan"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Masa Kerja
                                                Golongan</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="number" name="masa_kerja_golongan_tahun"
                                                    value="{{ $item->masa_kerja_golongan_tahun }}"
                                                    placeholder="Tahun"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                <input type="number" name="masa_kerja_golongan_bulan"
                                                    value="{{ $item->masa_kerja_golongan_bulan }}"
                                                    placeholder="Bulan"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload File
                                                Dokumen</label>
                                            <input type="file" name="file_dokumen"
                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin
                                                mengubah file</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <textarea name="keterangan" rows="3"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ $item->keterangan }}</textarea>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end mt-6 space-x-3">
                                    <button type="button" @click="editId = null"
                                        class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                                        Simpan Perubahan
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
               




                <!-- Modal Tambah Data Dosen -->
                <div x-show="openTambah" x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay z-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                        <!-- Header -->
                        <div class="bg-green-600 text-white p-4 rounded-t-lg">
                            <h2 class="text-lg font-semibold">Tambah Data Dosen</h2>
                        </div>

                        <form action="{{ route('dokumen-dosen.store') }}" method="POST"
                            enctype="multipart/form-data" class="p-5">
                            @csrf

                            <!-- Grid 2 Kolom -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Kolom Kiri -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                                        <input type="text" name="nama" required
                                            placeholder="Masukkan nama dosen"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NIK *</label>
                                        <input type="text" name="nik" required placeholder="Masukkan NIK"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat
                                            Lahir</label>
                                        <input type="text" name="tempat_lahir" placeholder="Masukkan tempat lahir"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                            Lahir</label>
                                        <input type="date" name="tanggal_lahir"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan
                                            Terakhir</label>
                                        <select name="pendidikan_terakhir" required
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">-- Pilih Pendidikan --</option>
                                            <option value="SMA/SMK">SMA/SMK/Sederajat</option>
                                            <option value="D3">D3</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <input type="text" name="jabatan" placeholder="Masukkan jabatan dosen"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">TMT Kerja</label>
                                        <input type="date" name="tmt_kerja"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Golongan</label>
                                        <input type="text" name="golongan" placeholder="Masukkan golongan dosen"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Masa Kerja</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="number" name="masa_kerja_tahun" placeholder="Tahun"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                            <input type="number" name="masa_kerja_bulan" placeholder="Bulan"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Masa Kerja
                                            Golongan</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="number" name="masa_kerja_golongan_tahun"
                                                placeholder="Tahun"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                            <input type="number" name="masa_kerja_golongan_bulan"
                                                placeholder="Bulan"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                       focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload File
                                            Dokumen</label>
                                        <input type="file" name="file_dokumen"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Maks.
                                            5MB)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <textarea name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan (opsional)"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm 
                           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-end mt-6 space-x-3">
                                <button type="button" @click="openTambah = false"
                                    class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500 transition text-sm font-medium">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition text-sm font-medium">
                                    Simpan Data
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
