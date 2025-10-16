<?php

namespace App\Http\Controllers;

use App\Models\DokumenMouPascasarjana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenMouPascasarjanaController extends Controller
{
    public function index()
    {
        $dokumen_pascasarjana = DokumenMouPascasarjana::all();
        return view('page.dokumen_pascasarjana.index', compact('dokumen_pascasarjana'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_mou' => 'required|string|max:255',
            'nomor_mou' => 'nullable|string|max:255',
            'lembaga_mitra' => 'nullable|string|max:255',
            'jenis_kerjasama' => 'nullable|string|max:255',
            'tingkat_kerjasama' => 'nullable|string|max:255',
            'tanggal_ttd' => 'nullable|date',
            'masa_berlaku' => 'nullable|string|max:225',
            'penanggung_jawab' => 'nullable|string|max:225',
            'program_studi' => 'nullable|string|max:255',
            'jenis_kegiatan' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        $filePath = $request->hasFile('file_dokumen')
            ? $request->file('file_dokumen')->store('dokumen_pascasarjana', 'public')
            : null;

        DokumenMouPascasarjana::create($request->all() + ['file_dokumen' => $filePath]);

        return redirect()->route('dokumen_pascasarjana.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $data = DokumenMouPascasarjana::findOrFail($id);

        $request->validate([
            'judul_mou' => 'required|string|max:255',
            'nomor_mou' => 'nullable|string|max:255',
            'lembaga_mitra' => 'nullable|string|max:255',
            'jenis_kerjasama' => 'nullable|string|max:255',
            'tingkat_kerjasama' => 'nullable|string|max:255',
            'tanggal_ttd' => 'nullable|date',
            'masa_berlaku' => 'nullable|string|max:225',
            'penanggung_jawab' => 'nullable|string|max:225',
            'program_studi' => 'nullable|string|max:255',
            'jenis_kegiatan' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'keterangan' => 'nullable|string',
        ]);

        $updateData = $request->except('file_dokumen');

        if ($request->hasFile('file_dokumen')) {
            if ($data->file_dokumen && Storage::disk('public')->exists($data->file_dokumen)) {
                Storage::disk('public')->delete($data->file_dokumen);
            }
            $updateData['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_pascasarjana', 'public');
        }

        $data->update($updateData);

        return redirect()->route('dokumen_pascasarjana.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $data = DokumenMouPascasarjana::findOrFail($id);
        if ($data->file_dokumen && Storage::disk('public')->exists($data->file_dokumen)) {
            Storage::disk('public')->delete($data->file_dokumen);
        }
        $data->delete();
        return redirect()->route('dokumen_pascasarjana.index')->with('success', 'Data berhasil dihapus');
    }
}
