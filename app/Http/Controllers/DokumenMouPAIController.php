<?php

namespace App\Http\Controllers;


use App\Models\DokumenMouPAI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenMouPAIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_pai = DokumenMouPAI::paginate(10);
        return view('page.dokumen_pai.index', compact('dokumen_pai'));
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

        // Simpan file ke storage/public/dokumen_pai
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_pai', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenMouPAI::create([
            'judul_dokumen' => $request->judul_dokumen,
            'nomor_mou' => $request->nomor_mou,
            'tanggal_mou' => $request->tanggal_mou,
            'pihak_kerjasama' => $request->pihak_kerjasama,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_pai.index')
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
        $dokumen_pai = DokumenMouPAI::findOrFail($id);

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
            if ($dokumen_pai->file && Storage::disk('public')->exists($dokumen_pai->file)) {
                Storage::disk('public')->delete($dokumen_pai->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_pai', 'public');
        }

        $dokumen_pai->update($data);

        return redirect()->route('dokumen_pai.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_pai = DokumenMouPAI::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_pai->file && Storage::disk('public')->exists($dokumen_pai->file)) {
            Storage::disk('public')->delete($dokumen_pai->file);
        }

        $dokumen_pai->delete();

        return redirect()->route('dokumen_pai.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
