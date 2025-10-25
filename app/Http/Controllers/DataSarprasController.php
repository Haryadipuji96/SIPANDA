<?php

namespace App\Http\Controllers;

use App\Models\DataSarpras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataSarprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_sarpras = DataSarpras::paginate(10);
        return view('page.data_sarpras.index', compact('data_sarpras'));
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
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'kondisi' => 'required|string',
            'tanggal_pengadaan' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720',
        ]);

        // Simpan file ke storage/public/data_sarpras
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('data_sarpras', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DataSarpras::create([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'lokasi' => $request->lokasi,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'keterangan' => $request->keterangan,
            'file_dokumen' => $filePath,
        ]);

        return redirect()->route('data_sarpras.index')
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
        $data_sarpras = DataSarpras::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'kondisi' => 'required|string',
            'tanggal_pengadaan' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720',
        ]);

        $data = $request->only('nama_barang', 'kategori', 'lokasi', 'jumlah', 'kondisi', 'tanggal_pengadaan', 'keterangan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($data_sarpras->file && Storage::disk('public')->exists($data_sarpras->file)) {
                Storage::disk('public')->delete($data_sarpras->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('data_sarpras', 'public');
        }

        $data_sarpras->update($data);

        return redirect()->route('data_sarpras.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data_sarpras = DataSarpras::findOrFail($id);

        // Hapus file jika ada
        if ($data_sarpras->file && Storage::disk('public')->exists($data_sarpras->file)) {
            Storage::disk('public')->delete($data_sarpras->file);
        }

        $data_sarpras->delete();

        return redirect()->route('data_sarpras.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DataSarpras::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DataSarpras::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
