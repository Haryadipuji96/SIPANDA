<?php

namespace App\Http\Controllers;

use App\Models\DokumenEkonomi;
use Illuminate\Http\Request;

class DokumenEkonomiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen = DokumenEkonomi::paginate(10);
        return view('page.ekonomi.index', compact('dokumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.ekonomi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:30720',
        ]);

        $filePath = $request->file('file')->store('dokumen-ekonomi', 'public');

        DokumenEkonomi::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('dokumen-ekonomi.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumenEkonomi $dokumen_ekonomi)
    {
        return view('page.ekonomi.edit', compact('dokumen_ekonomi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenEkonomi $dokumen_ekonomi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg|max:30720',
        ]);

        $data = $request->only(['judul', 'kategori', 'deskripsi']);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('dokumen-ekonomi', 'public');
            $data['file'] = $path;
        }

        $dokumen_ekonomi->update($data);

        return redirect()->route('dokumen-ekonomi.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenEkonomi $dokumen_ekonomi)
    {
        $dokumen_ekonomi->delete();
        return redirect()->route('dokumen-ekonomi.index')->with('success', 'Data berhasil dihapus!');
    }
}
