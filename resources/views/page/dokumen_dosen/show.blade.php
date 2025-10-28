<x-app-layout>
    <div class="py-8 px-6">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Dokumen Dosen</h2>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p><span class="font-semibold">Nama:</span> {{ $dosen->nama }}</p>
                    <p><span class="font-semibold">NIK:</span> {{ $dosen->nik }}</p>
                    <p><span class="font-semibold">Tempat Lahir:</span> {{ $dosen->tempat_lahir }}</p>
                    <p><span class="font-semibold">Tanggal Lahir:</span> {{ $dosen->tanggal_lahir }}</p>
                    <p><span class="font-semibold">Pendidikan Terakhir:</span> {{ $dosen->pendidikan_terakhir }}</p>
                    <p><span class="font-semibold">Jabatan:</span> {{ $dosen->jabatan }}</p>
                </div>
                <div>
                    <p><span class="font-semibold">TMT Kerja:</span> {{ $dosen->tmt_kerja }}</p>
                    <p><span class="font-semibold">Masa Kerja:</span>
                        {{ $dosen->masa_kerja_tahun }} Tahun
                        {{ $dosen->masa_kerja_bulan }} Bulan
                    </p>
                    <p><span class="font-semibold">Golongan:</span> {{ $dosen->golongan }}</p>
                    <p><span class="font-semibold">Masa Kerja Golongan:</span>
                        {{ $dosen->masa_kerja_golongan_tahun }} Tahun
                        {{ $dosen->masa_kerja_golongan_bulan }} Bulan
                    </p>
                </div>
            </div>

            <div class="mt-6">
                @if ($dosen->file_dokumen)
                    <p class="font-semibold mb-2">File Dokumen:</p>
                    <a href="{{ asset('storage/' . $dosen->file_dokumen) }}" target="_blank"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Lihat Dokumen
                    </a>
                @else
                    <p class="text-gray-500">Tidak ada file dokumen diunggah.</p>
                @endif
            </div>

            <div class="mt-8">
                <a href="{{ route('dokumen-dosen.index') }}"
                   class="inline-block px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
