<?php

namespace App\Http\Controllers;

use App\Models\DokumenDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $dokumen_dosen = DokumenDosen::paginate(10);
        return view('page.dokumen_dosen.index', compact('dokumen_dosen'));
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
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|max:20|unique:dokumen_dosens,nik',
            'pendidikan_terakhir' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'tmt_kerja' => 'required|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'golongan' => 'nullable|string|max:50',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
        ]);

        // Simpan file ke storage/public/dokumen_dosen
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('dokumen_dosen', 'public');
        } else {
            $filePath = null;
        }

        // Simpan data ke database
        DokumenDosen::create([
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nik' => $request->nik,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jabatan' => $request->jabatan,
            'tmt_kerja' => $request->tmt_kerja,
            'masa_kerja_tahun' => $request->masa_kerja_tahun,
            'masa_kerja_bulan' => $request->masa_kerja_bulan,
            'golongan' => $request->golongan,
            'masa_kerja_golongan_tahun' => $request->masa_kerja_golongan_tahun,
            'masa_kerja_golongan_bulan' => $request->masa_kerja_golongan_bulan,
            'file_dokumen' => $filePath,

        ]);

        return redirect()->route('dokumen-dosen.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dosen = DokumenDosen::findOrFail($id);
        return view('page.dokumen_dosen.show', compact('dosen'));
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
        $dokumen_dosen = DokumenDosen::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|max:20|unique:dokumen_dosens,nik,' . $id,
            'pendidikan_terakhir' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'tmt_kerja' => 'required|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'golongan' => 'nullable|string|max:50',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
        ]);

        $data = $request->only('nama', 'tempat_lahir', 'tanggal_lahir', 'nik', 'pendidikan_terakhir', 'jabatan', 'tmt_kerja', 'masa_kerja_tahun', 'masa_kerja_bulan', 'golongan', 'masa_kerja_golongan_tahun', 'masa_kerja_golongan_bulan');

        // Jika ada file baru, hapus file lama dan simpan file baru
        if ($request->hasFile('file_dokumen')) {
            if ($dokumen_dosen->file && Storage::disk('public')->exists($dokumen_dosen->file)) {
                Storage::disk('public')->delete($dokumen_dosen->file);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_dosen', 'public');
        }

        $dokumen_dosen->update($data);

        return redirect()->route('dokumen-dosen.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen_dosen = DokumenDosen::findOrFail($id);

        // Hapus file jika ada
        if ($dokumen_dosen->file && Storage::disk('public')->exists($dokumen_dosen->file)) {
            Storage::disk('public')->delete($dokumen_dosen->file);
        }

        $dokumen_dosen->delete();

        return redirect()->route('dokumen-dosen.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = DokumenDosen::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        DokumenDosen::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
