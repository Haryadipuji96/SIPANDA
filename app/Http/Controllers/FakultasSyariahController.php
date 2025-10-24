<?php

namespace App\Http\Controllers;

use App\Models\FakultasSyariah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FakultasSyariahController extends Controller
{
    public function index()
    {
        $fakultas_syariahs = FakultasSyariah::paginate(10);
        return view('page.fakultas_syariahs.index', compact('fakultas_syariahs'));
    }

    public function create()
    {
        return view('page.fakultas_syariahs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
            'dekan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:30720',
        ]);

        $filePath = $request->file('file')->store('fakultas_syariahs', 'public');

        FakultasSyariah::create([
            'nama_fakultas' => $request->nama_fakultas,
            'dekan' => $request->dekan,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('fakultas_syariahs.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(FakultasSyariah $fakultas_syariah)
    {
        return view('page.fakultas_syariahs.edit', compact('fakultas_syariah'));
    }

    public function update(Request $request, FakultasSyariah $fakultas_syariah)
    {
        $data = $request->only('nama_fakultas', 'dekan', 'deskripsi');

        if ($request->hasFile('file')) {
            if ($fakultas_syariah->file) {
                Storage::delete('public/' . $fakultas_syariah->file);
            }
            $data['file'] = $request->file('file')->store('fakultas_syariahs', 'public');
        }

        $fakultas_syariah->update($data);

        return redirect()->route('fakultas_syariahs.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(FakultasSyariah $fakultas_syariah)
    {
        if ($fakultas_syariah->file) {
            Storage::delete('public/' . $fakultas_syariah->file);
        }
        $fakultas_syariah->delete();

        return redirect()->route('fakultas_syariahs.index')->with('success', 'Data berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        // hapus file lama jika perlu
        $items = FakultasSyariah::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file && Storage::exists('public/' . $item->file)) {
                Storage::delete('public/' . $item->file);
            }
        }

        FakultasSyariah::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }
}
