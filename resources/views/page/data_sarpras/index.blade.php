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

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Data Sarana & Prasarana</h1>
                <button @click="openTambah = true"
                    class="flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition duration-200 ease-in-out transform hover:scale-105">
                    + Tambah
                    Data</button>
            </div>

            {{-- Pesan sukses --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form id="bulkDeleteForm" action="{{ route('data_sarpras.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-between items-center mb-2">
                    <button type="submit"
                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 disabled:opacity-50"
                        id="deleteSelected" disabled>
                        Hapus Terpilih
                    </button>
                </div>


                {{-- Tabel Data --}}
                <div id="table-wrapper" class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-green-600 text-white">
                            <tr>
                                <th class="px-4 py-2 border text-center">
                                    <input type="checkbox" id="selectAll"
                                        class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                </th>
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
                                <tr id="row-{{ $item->id }}"
                                    class="
                                    {{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}
                                    {{ $highlight &&
                                    (str_contains(strtolower($item->nama_barang), strtolower($highlight)) ||
                                        str_contains(strtolower($item->kategori ?? ''), strtolower($highlight)) ||
                                        str_contains(strtolower($item->lokasi ?? ''), strtolower($highlight)))
                                        ? 'fade-once'
                                        : '' }}">
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            class="select-item cursor-pointer appearance-none w-4 h-4 border-2 border-gray-400 rounded-sm checked:bg-green-600 checked:border-green-600 transition-all duration-150">
                                    </td>
                                   <td class="border px-4 py-2 text-center">{{ $data_sarpras->firstItem() + $index }}
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
                                            <form action="{{ route('data_sarpras.destroy', $item) }}" method="POST"
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-gray-600">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @include('components.pagination', ['data' => $data_sarpras])
        </div>

        {{-- Modal Tambah Data --}}
        <div x-show="openTambah" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
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

                    <input type="date" name="tanggal_pengadaan"
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">

                    <textarea name="keterangan" placeholder="Keterangan" class="w-full border px-2 py-1 mb-2 rounded text-sm"></textarea>

                    <input type="file" name="file_dokumen"
                        class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">

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
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 modal-overlay">
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

                        <input type="file" name="file_dokumen"
                            class="w-full border border-gray-500 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
