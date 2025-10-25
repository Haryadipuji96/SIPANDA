<?php

namespace App\Http\Controllers;

use App\Models\FakultasTarbiyah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FakultasTarbiyahController extends Controller
{
    public function index()
    {
        $fakultas_tarbiyah = FakultasTarbiyah::paginate(10);
        return view('page.fakultas_tarbiyah.index', compact('fakultas_tarbiyah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_mou' => 'required|string|max:255',
            'mitra_kerjasama' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'bidang_kerjasama' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx|max:30720',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('fakultas_tarbiyah', 'public');
        }

        FakultasTarbiyah::create($validated);

        return redirect()->route('fakultas_tarbiyah.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = FakultasTarbiyah::findOrFail($id);
        $validated = $request->validate([
            'judul_mou' => 'required|string|max:255',
            'mitra_kerjasama' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'bidang_kerjasama' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx|max:30720',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('fakultas_tarbiyah', 'public');
        }

        $item->update($validated);

        return redirect()->route('fakultas_tarbiyah.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = FakultasTarbiyah::findOrFail($id);
        $item->delete();
        return redirect()->route('fakultas_tarbiyah.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = FakultasTarbiyah::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        FakultasTarbiyah::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
