<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="p-6" x-data="{ openTambah: false, editId: null }">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">👥 Manajemen Pengguna</h1>
                <button @click="openTambah = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                    + Tambah Pengguna
                </button>
            </div>

            <!-- Notifikasi -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabel -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-2 border text-left">Nama</th>
                            <th class="px-4 py-2 border text-left">Email</th>
                            <th class="px-4 py-2 border text-left">Role</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-200' : 'bg-gray-100' }}">
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2 capitalize">{{ $user->role }}</td>
                                <td class="border px-4 py-2 text-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button @click="editId = {{ $user->id }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <!-- Modal Edit -->
                                    <div x-show="editId === {{ $user->id }}" x-cloak
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-lg w-96 shadow-lg">
                                            <h2 class="text-lg font-bold mb-4">Edit Pengguna</h2>
                                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="text" name="name" value="{{ $user->name }}"
                                                    required class="w-full border px-2 py-1 mb-2 rounded text-sm"
                                                    placeholder="Nama">

                                                <input type="email" name="email" value="{{ $user->email }}"
                                                    required class="w-full border px-2 py-1 mb-2 rounded text-sm"
                                                    placeholder="Email">

                                                <select name="role"
                                                    class="w-full border px-2 py-1 mb-2 rounded text-sm" required>
                                                    <option value="dosen"
                                                        {{ $user->role === 'dosen' ? 'selected' : '' }}>
                                                        Dosen</option>
                                                    <option value="kepegawaian"
                                                        {{ $user->role === 'kepegawaian' ? 'selected' : '' }}>
                                                        Kepegawaian</option>
                                                </select>

                                                <input type="password" name="password"
                                                    placeholder="Kosongkan jika tidak diganti"
                                                    class="w-full border px-2 py-1 mb-2 rounded text-sm">

                                                <div class="flex justify-end space-x-2">
                                                    <button type="button" @click="editId = null"
                                                        class="px-3 py-1 bg-gray-400 rounded text-sm">Batal</button>
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-green-600 text-white rounded text-sm">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
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
                                    `
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500 bg-gray-50">
                                    Belum ada data pengguna.
                                </td>
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
                <h2 class="text-lg font-bold mb-4">Tambah Pengguna</h2>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <input type="text" name="name" placeholder="Nama" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full border px-2 py-1 mb-2 rounded text-sm">

                    <select name="role" class="w-full border px-2 py-1 mb-2 rounded text-sm" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="dosen">Dosen</option>
                        <option value="kepegawaian">Kepegawaian</option>
                    </select>

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
