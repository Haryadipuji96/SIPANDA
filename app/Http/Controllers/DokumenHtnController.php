<?php

namespace App\Http\Controllers;

use App\Models\DokumenHtn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenHtnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_htn = DokumenHtn::paginate(10);
        return view('page.dokumen_htn.index', compact('dokumen_htn'));
    }

    /**
     * Show the form for creating a new resource.
     * Tidak digunakan karena form berada di modal blade.
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
            'lembaga_mitra' => 'required|string|max:255',
            'nomor_mou' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:30720',
        ]);

        // Simpan file ke storage/public/dokumen_htn
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('dokumen_htn', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenHtn::create([
            'judul_mou' => $request->judul_mou,
            'lembaga_mitra' => $request->lembaga_mitra,
            'nomor_mou' => $request->nomor_mou,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('dokumen_htn.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Tidak digunakan karena edit ada di modal blade.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dokumen_htn = DokumenHtn::findOrFail($id);

        $request->validate([
            'judul_mou' => 'required|string|max:255',
            'lembaga_mitra' => 'required|string|max:255',
            'nomor_mou' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg|max:30720',
        ]);

        $data = $request->only('judul_mou', 'lembaga_mitra', 'nomor_mou', 'kategori', 'deskripsi');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file')) {
            if ($dokumen_htn->file && Storage::disk('public')->exists($dokumen_htn->file)) {
                Storage::disk('public')->delete($dokumen_htn->file);
            }
            $data['file'] = $request->file('file')->store('dokumen_htn', 'public');
        }

        $dokumen_htn->update($data);

        return redirect()->route('dokumen_htn.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dokumen_htn = DokumenHtn::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_htn->file && Storage::disk('public')->exists($dokumen_htn->file)) {
            Storage::disk('public')->delete($dokumen_htn->file);
        }

        $dokumen_htn->delete();

        return redirect()->route('dokumen_htn.index')
            ->with('success', 'Data berhasil dihapus');
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenHtn::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenHtn::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
