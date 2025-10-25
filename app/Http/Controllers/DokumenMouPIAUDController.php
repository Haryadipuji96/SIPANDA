<?php

namespace App\Http\Controllers;

use App\Models\DokumenMoU_PIAUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenMouPIAUDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_piaud = DokumenMoU_PIAUD::paginate(10);
        return view('page.dokumen_piaud.index', compact('dokumen_piaud'));
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
            'judul_dokumen' => 'required|string|max:255',
            'nomor_mou' => 'nullable|string|max:255',
            'tanggal_mou' => 'nullable|date',
            'pihak_kerjasama' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan file ke storage/public/dokumen_piaud
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_piaud', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenMoU_PIAUD::create([
            'judul_dokumen' => $request->judul_dokumen,
            'nomor_mou' => $request->nomor_mou,
            'tanggal_mou' => $request->tanggal_mou,
            'pihak_kerjasama' => $request->pihak_kerjasama,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_piaud.index')
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
        $dokumen_piaud = DokumenMoU_PIAUD::findOrFail($id);

        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'nomor_mou' => 'nullable|string|max:255',
            'tanggal_mou' => 'nullable|date',
            'pihak_kerjasama' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->only('judul_dokumen', 'nomor_mou', 'tanggal_mou', 'pihak_kerjasama', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_piaud->file && Storage::disk('public')->exists($dokumen_piaud->file)) {
                Storage::disk('public')->delete($dokumen_piaud->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_piaud', 'public');
        }

        $dokumen_piaud->update($data);

        return redirect()->route('dokumen_piaud.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_piaud = DokumenMoU_PIAUD::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_piaud->file && Storage::disk('public')->exists($dokumen_piaud->file)) {
            Storage::disk('public')->delete($dokumen_piaud->file);
        }

        $dokumen_piaud->delete();

        return redirect()->route('dokumen_piaud.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenMoU_PIAUD::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenMoU_PIAUD::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
