<?php

namespace App\Http\Controllers;

use App\Models\DokumenMou_MPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenMouMPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen_mpi = DokumenMou_MPI::all();
        return view('page.dokumen_mpi.index', compact('dokumen_mpi'));
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

        // Simpan file ke storage/public/dokumen_mpi
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_mpi', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenMou_MPI::create([
            'judul_dokumen' => $request->judul_dokumen,
            'nomor_mou' => $request->nomor_mou,
            'tanggal_mou' => $request->tanggal_mou,
            'pihak_kerjasama' => $request->pihak_kerjasama,
            'file_dokumen' => $filePath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dokumen_mpi.index')
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
        $dokumen_mpi = DokumenMou_MPI::findOrFail($id);

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
            if ($dokumen_mpi->file_dokumen && Storage::disk('public')->exists($dokumen_mpi->file_dokumen)) {
                Storage::disk('public')->delete($dokumen_mpi->file_dokumen);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_mpi', 'public');
        }

        $dokumen_mpi->update($data);

        return redirect()->route('dokumen_mpi.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_mpi = DokumenMou_MPI::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_mpi->file_dokumen && Storage::disk('public')->exists($dokumen_mpi->file_dokumen)) {
            Storage::disk('public')->delete($dokumen_mpi->file_dokumen);
        }

        $dokumen_mpi->delete();

        return redirect()->route('dokumen_mpi.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
