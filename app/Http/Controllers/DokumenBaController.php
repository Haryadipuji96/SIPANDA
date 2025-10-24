<?php

namespace App\Http\Controllers;

use App\Models\DokumenBa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenBaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_ba = DokumenBa::paginate(10);
        return view('page.dokumen_ba.index', compact('dokumen_ba'));
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
            'nomor_ba' => 'nullable|string|max:255',
            'tanggal_ba' => 'nullable|date',
            'tempat' => 'nullable|string|max:255',
            'pihak_terlibat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
        ]);

        // Simpan file ke storage/public/dokumen_ba
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_ba', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenBa::create([
            'judul' => $request->judul,
            'nomor_ba' => $request->nomor_ba,
            'tanggal_ba' => $request->tanggal_ba,
            'tempat' => $request->tempat,
            'pihak_terlibat' => $request->pihak_terlibat,
            'keterangan' => $request->keterangan,
            'file_dokumen' => $filePath,
        ]);

        return redirect()->route('dokumen_ba.index')
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
        $dokumen_ba = DokumenBa::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_ba' => 'nullable|string|max:255',
            'tanggal_ba' => 'nullable|date',
            'tempat' => 'nullable|string|max:255',
            'pihak_terlibat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
        ]);

        $data = $request->only('judul', 'nomor_ba', 'tanggal_ba', 'tempat', 'pihak_terlibat', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_ba->file && Storage::disk('public')->exists($dokumen_ba->file)) {
                Storage::disk('public')->delete($dokumen_ba->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_ba', 'public');
        }

        $dokumen_ba->update($data);

        return redirect()->route('dokumen_ba.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_ba = DokumenBa::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_ba->file && Storage::disk('public')->exists($dokumen_ba->file)) {
            Storage::disk('public')->delete($dokumen_ba->file);
        }

        $dokumen_ba->delete();

        return redirect()->route('dokumen_ba.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
