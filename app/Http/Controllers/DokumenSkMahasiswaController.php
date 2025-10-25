<?php

namespace App\Http\Controllers;

use App\Models\DokumenSkMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenSkMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_sk_mahasiswa = DokumenSkMahasiswa::paginate(10);
        return view('page.dokumen_sk_mahasiswa.index', compact('dokumen_sk_mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_sk' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan file ke storage/public/dokumen_piaud
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_sk_mahasiswa', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenSkMahasiswa::create([
            'judul' => $request->judul,
            'nomor_sk' => $request->nomor_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_sk_mahasiswa.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dokumen_sk_mahasiswa = DokumenSkMahasiswa::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_sk' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->only('judul', 'nomor_sk', 'tanggal_sk', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_sk_mahasiswa->file && Storage::disk('public')->exists($dokumen_sk_mahasiswa->file)) {
                Storage::disk('public')->delete($dokumen_sk_mahasiswa->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_sk_mahasiswa', 'public');
        }

        $dokumen_sk_mahasiswa->update($data);

        return redirect()->route('dokumen_sk_mahasiswa.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_sk_mahasiswa = DokumenSkMahasiswa::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_sk_mahasiswa->file && Storage::disk('public')->exists($dokumen_sk_mahasiswa->file)) {
            Storage::disk('public')->delete($dokumen_sk_mahasiswa->file);
        }

        $dokumen_sk_mahasiswa->delete();

        return redirect()->route('dokumen_sk_mahasiswa.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenSkMahasiswa::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenSkMahasiswa::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
