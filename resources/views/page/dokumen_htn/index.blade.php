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

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 text-center sm:text-left">
                    Dokumen HTN
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


            <form id="bulkDeleteForm" action="{{ route('dokumen_htn.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-between items-center mb-2">
                    @canAdmin
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
                    @endcanAdmin
                </div>
            </form>

                <!-- Tabel -->
                <div class="table-wrapper border border-gray-200 rounded-lg">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-green-600 text-white">
                            <tr>
                                @canAdmin
                                <th class="px-4 py-2 border text-center">
                                    <input type="checkbox" id="selectAll"
                                        class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                </th>
                                @endcanAdmin
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
                                <tr id="row-{{ $item->id }}"
                                    class="
                                    {{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}
                                    {{ $highlight &&
                                    (str_contains(strtolower($item->judul_mou), strtolower($highlight)) ||
                                        str_contains(strtolower($item->lembaga_mitra ?? ''), strtolower($highlight)) ||
                                        str_contains(strtolower($item->kategori ?? ''), strtolower($highlight)))
                                        ? 'fade-once'
                                        : '' }}
                                ">
                                    @canAdmin
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                    </td>
                                    @endcanAdmin
                                    <td class="border px-4 py-2 text-center">{{ $dokumen_htn->firstItem() + $index }}
                                    </td>
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
                                        @canAdmin
                                        <div class="flex items-center justify-center gap-3">
                                            <!-- Edit -->
                                            <button type="button" @click="editId = {{ $item->id }}"
                                                class="p-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full transition"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>

                                            <!-- Hapus -->
                                            <form action="{{ route('dokumen_htn.destroy', $item) }}" method="POST"
                                                class="inline">
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
                                        @endcanAdmin
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

                                            <input type="text" name="judul_mou" value="{{ $item->judul_mou }}"
                                                required class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                            <input type="text" name="lembaga_mitra"
                                                value="{{ $item->lembaga_mitra }}" required
                                                class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                            <input type="text" name="nomor_mou" value="{{ $item->nomor_mou }}"
                                                required class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                            <input type="text" name="kategori" value="{{ $item->kategori }}"
                                                required class="w-full border px-2 py-1 mb-2 rounded text-sm">

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
