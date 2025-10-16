<?php

namespace App\Http\Controllers;

use App\Models\DokumenDosen;
use App\Models\Dosen;
use App\Models\KategoriDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenDosenController extends Controller
{
    // ✅ Menampilkan semua dokumen
    public function index()
    {
        $dokumen = DokumenDosen::with(['dosen', 'kategori'])->latest()->get();
        $dosens = Dosen::all();
        $kategoris = KategoriDokumen::all();

        return view('page.dokumen_dosen.index', compact('dokumen', 'dosens', 'kategoris'));
    }

    // ✅ Menyimpan dokumen baru
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'kategori_id' => 'required|exists:kategori_dokumens,id',
            'nama_dokumen' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        // Upload file ke storage
        $path = $request->file('file_path')->store('dokumen_dosen', 'public');

        DokumenDosen::create([
            'dosen_id' => $request->dosen_id,
            'kategori_id' => $request->kategori_id,
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $path,
            'tanggal_upload' => now(),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan!');
    }

    // ✅ Update dokumen
    public function update(Request $request, $id)
    {
        $dokumen = DokumenDosen::findOrFail($id);

        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'kategori_id' => 'required|exists:kategori_dokumens,id',
            'nama_dokumen' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        // Jika file baru diupload, hapus yang lama
        if ($request->hasFile('file_path')) {
            if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $path = $request->file('file_path')->store('dokumen_dosen', 'public');
            $dokumen->file_path = $path;
        }

        $dokumen->update([
            'dosen_id' => $request->dosen_id,
            'kategori_id' => $request->kategori_id,
            'nama_dokumen' => $request->nama_dokumen,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui!');
    }

    // ✅ Hapus dokumen
    public function destroy($id)
    {
        $dokumen = DokumenDosen::findOrFail($id);

        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');
    }
}
