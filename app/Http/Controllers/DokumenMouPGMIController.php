<?php

namespace App\Http\Controllers;


use App\Models\DokumenMouPGMI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenMouPGMIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_pgmi = DokumenMouPGMI::paginate(10);
        return view('page.dokumen_pgmi.index', compact('dokumen_pgmi'));
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

        // Simpan file ke storage/public/dokumen_gmi
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_pgmi', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenMouPGMI::create([
            'judul_dokumen' => $request->judul_dokumen,
            'nomor_mou' => $request->nomor_mou,
            'tanggal_mou' => $request->tanggal_mou,
            'pihak_kerjasama' => $request->pihak_kerjasama,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_pgmi.index')
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
        $dokumen_pgmi = DokumenMouPGMI::findOrFail($id);

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
            if ($dokumen_pgmi->file && Storage::disk('public')->exists($dokumen_pgmi->file)) {
                Storage::disk('public')->delete($dokumen_pgmi->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_pgmi', 'public');
        }

        $dokumen_pgmi->update($data);

        return redirect()->route('dokumen_pgmi.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_pgmi = DokumenMouPGMI::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_pgmi->file && Storage::disk('public')->exists($dokumen_pgmi->file)) {
            Storage::disk('public')->delete($dokumen_pgmi->file);
        }

        $dokumen_pgmi->delete();

        return redirect()->route('dokumen_pgmi.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenMouPGMI::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenMouPGMI::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
