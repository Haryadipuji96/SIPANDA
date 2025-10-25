<?php

namespace App\Http\Controllers;

use App\Models\DokumenPeraturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenPeraturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_peraturan = DokumenPeraturan::paginate(10);
        return view('page.dokumen_peraturan.index', compact('dokumen_peraturan'));
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
            'nomor_peraturan' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'tanggal_terbit' => 'nullable|date',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan file ke storage/public/dokumen_peraturan
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_peraturan', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenPeraturan::create([
            'judul' => $request->judul,
            'nomor_peraturan' => $request->nomor_peraturan,
            'kategori' => $request->kategori,
            'tanggal_terbit' => $request->tanggal_terbit,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_peraturan.index')
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
        $dokumen_peraturan = DokumenPeraturan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_peraturan' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'tanggal_terbit' => 'nullable|date',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->only('judul', 'nomor_peraturan', 'kategori', 'tanggal_terbit', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_peraturan->file && Storage::disk('public')->exists($dokumen_peraturan->file)) {
                Storage::disk('public')->delete($dokumen_peraturan->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_peraturan', 'public');
        }

        $dokumen_peraturan->update($data);

        return redirect()->route('dokumen_peraturan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_peraturan = DokumenPeraturan::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_peraturan->file && Storage::disk('public')->exists($dokumen_peraturan->file)) {
            Storage::disk('public')->delete($dokumen_peraturan->file);
        }

        $dokumen_peraturan->delete();

        return redirect()->route('dokumen_peraturan.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenPeraturan::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenPeraturan::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
