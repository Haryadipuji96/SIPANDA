<?php

namespace App\Http\Controllers;


use App\Models\DokumenSkInstitusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenSkInstitusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_sk_institusi = DokumenSkInstitusi::all();
        return view('page.dokumen_sk_institusi.index', compact('dokumen_sk_institusi'));
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
            'unit_penerbit' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan file ke storage/public/dokumen_piaud
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_sk_institusi', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenSkInstitusi::create([
            'judul' => $request->judul,
            'nomor_sk' => $request->nomor_sk,
            'tanggal_sk' => $request->tanggal_sk,
            'unit_penerbit' => $request->unit_penerbit,
            'kategori' => $request->kategori,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_sk_institusi.index')
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
        $dokumen_sk_institusi = DokumenSkInstitusi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_sk' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'unit_penerbit' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->only('judul', 'nomor_sk', 'tanggal_sk', 'unit_penerbit', 'kategori', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_sk_institusi->file && Storage::disk('public')->exists($dokumen_sk_institusi->file)) {
                Storage::disk('public')->delete($dokumen_sk_institusi->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_sk_institusi', 'public');
        }

        $dokumen_sk_institusi->update($data);

        return redirect()->route('dokumen_sk_institusi.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_sk_institusi = DokumenSkInstitusi::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_sk_institusi->file && Storage::disk('public')->exists($dokumen_sk_institusi->file)) {
            Storage::disk('public')->delete($dokumen_sk_institusi->file);
        }

        $dokumen_sk_institusi->delete();

        return redirect()->route('dokumen_sk_institusi.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
