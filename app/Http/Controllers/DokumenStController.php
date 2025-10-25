<?php

namespace App\Http\Controllers;

use App\Models\DokumenSt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenStController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_st = DokumenSt::paginate(10);
        return view('page.dokumen_st.index', compact('dokumen_st'));
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
            'nomor_st' => 'required|string|max:255',
            'tanggal_st' => 'required|date',
            'pemberi_tugas' => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
            'tugas' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
        ]);

        // Simpan file ke storage/public/dokumen_piaud
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_st', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenSt::create([
            'judul' => $request->judul,
            'nomor_st' => $request->nomor_st,
            'tanggal_st' => $request->tanggal_st,
            'pemberi_tugas' => $request->pemberi_tugas,
            'nama_petugas' => $request->nama_petugas,
            'tugas' => $request->tugas,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_st.index')
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
        $dokumen_st = DokumenSt::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'nomor_st' => 'required|string|max:255',
            'tanggal_st' => 'required|date',
            'pemberi_tugas' => 'required|string|max:255',
            'nama_petugas' => 'required|string|max:255',
            'tugas' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
        ]);

        $data = $request->only('judul', 'nomor_st', 'tanggal_st', 'pemberi_tugas', 'nama_petugas', 'tugas', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_st->file && Storage::disk('public')->exists($dokumen_st->file)) {
                Storage::disk('public')->delete($dokumen_st->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_st', 'public');
        }

        $dokumen_st->update($data);

        return redirect()->route('dokumen_st.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_st = DokumenSt::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_st->file && Storage::disk('public')->exists($dokumen_st->file)) {
            Storage::disk('public')->delete($dokumen_st->file);
        }

        $dokumen_st->delete();

        return redirect()->route('dokumen_st.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenSt::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenSt::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
