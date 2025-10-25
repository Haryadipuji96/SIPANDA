<?php

namespace App\Http\Controllers;

use App\Models\DokumenMouInstitutIAIT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenMouInstitutIAITController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_iait = DokumenMouInstitutIAIT::paginate(10);
        return view('page.dokumen_institutIAIT.index', compact('dokumen_iait'));
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
            'judul_mou' => 'required|string|max:255',
            'nomor_mou' => 'nullable|string|max:255',
            'lembaga_mitra' => 'nullable|string|max:255',
            'jenis_kerjasama' => 'nullable|string|max:255',
            'tingkat_kerjasama' => 'nullable|string|max:255',
            'tanggal_ttd' => 'nullable|date',
            'masa_berlaku' => 'nullable|string|max:225',
            'penanggung_jawab' => 'nullable|string|max:225',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan file ke storage/public/dokumen_iait
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_iait', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenMouInstitutIAIT::create([
            'judul_mou' => $request->judul_mou,
            'nomor_mou' => $request->nomor_mou,
            'lembaga_mitra' => $request->lembaga_mitra,
            'jenis_kerjasama' => $request->jenis_kerjasama,
            'tingkat_kerjasama' => $request->tingkat_kerjasama,
            'tanggal_ttd' => $request->tanggal_ttd,
            'masa_berlaku' => $request->masa_berlaku,
            'penanggung_jawab' => $request->penanggung_jawab,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_iait.index')
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
        $dokumen_iait = DokumenMouInstitutIAIT::findOrFail($id);

        $request->validate([
            'judul_mou' => 'required|string|max:255',
            'nomor_mou' => 'nullable|string|max:255',
            'lembaga_mitra' => 'nullable|string|max:255',
            'jenis_kerjasama' => 'nullable|string|max:255',
            'tingkat_kerjasama' => 'nullable|string|max:255',
            'tanggal_ttd' => 'nullable|date',
            'masa_berlaku' => 'nullable|string|max:225',
            'penanggung_jawab' => 'nullable|string|max:225',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->only('judul_mou', 'nomor_mou', 'lembaga_mitra', 'jenis_kerjasama', 'tingkat_kerjasama', 'tanggal_ttd', 'masa_berlaku', 'penanggung_jawab', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_iait->file && Storage::disk('public')->exists($dokumen_iait->file)) {
                Storage::disk('public')->delete($dokumen_iait->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_iait', 'public');
        }

        $dokumen_iait->update($data);

        return redirect()->route('dokumen_iait.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_iait = DokumenMouInstitutIAIT::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_iait->file && Storage::disk('public')->exists($dokumen_iait->file)) {
            Storage::disk('public')->delete($dokumen_iait->file);
        }

        $dokumen_iait->delete();

        return redirect()->route('dokumen_iait.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenMouInstitutIAIT::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenMouInstitutIAIT::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
