<?php

namespace App\Http\Controllers;

use App\Models\HKI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HKIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hki = HKI::paginate(10);
        return view('page.hki.index', compact('hki'));
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
            'nama_dokumen_kegiatan' => 'required|string|max:255',
            'tahun' => 'required|string|max:255',
            'fakultas' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:30720',
        ]);

        $filePath = $request->file('file')->store('hki', 'public');

        HKI::create([
            'nama_dokumen_kegiatan' => $request->nama_dokumen_kegiatan,
            'tahun' => $request->tahun,
            'fakultas' => $request->fakultas,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('hki.index')->with('success', 'Data berhasil ditambahkan');
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
    public function update(Request $request, $id)
    {
        $hki = HKI::findOrFail($id);

        $data = $request->only('nama_dokumen_kegiatan', 'tahun', 'fakultas', 'deskripsi');

        if ($request->hasFile('file')) {
            if ($hki->file) {
                Storage::disk('public')->delete($hki->file);
            }

            $data['file'] = $request->file('file')->store('hki', 'public');
        }

        $hki->update($data);

        return redirect()->route('hki.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hki = HKI::findOrFail($id);
        if ($hki->file) {
            Storage::delete($hki->file);
        }
        $hki->delete();

        return redirect()->route('hki.index')->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = HKI::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        HKI::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
