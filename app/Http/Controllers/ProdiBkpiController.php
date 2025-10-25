<?php

namespace App\Http\Controllers;

use App\Models\ProdiBkpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdiBkpiController extends Controller
{
    public function index()
    {
        $data = ProdiBkpi::paginate(10);
        return view('page.prodi_bkpi.index', compact('data'));
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
            $validated['file'] = $request->file('file')->store('dokumen_bkpi', 'public');
        }

        ProdiBkpi::create($validated);

        return redirect()->route('prodi_bkpi.index')->with('success', 'Dokumen BKPI berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = ProdiBkpi::findOrFail($id);
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
            $validated['file'] = $request->file('file')->store('dokumen_bkpi', 'public');
        }

        $item->update($validated);

        return redirect()->route('prodi_bkpi.index')->with('success', 'Dokumen BKPI berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = ProdiBkpi::findOrFail($id);
        $item->delete();
        return redirect()->route('prodi_bkpi.index')->with('success', 'Dokumen BKPI berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = ProdiBkpi::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        ProdiBkpi::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
