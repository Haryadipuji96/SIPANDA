<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fakultas = Fakultas::paginate(10);
        return view('page.fakultas.index', compact('fakultas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.fakultas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
            'dekan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:30720',
        ]);

        $filePath = $request->file('file')->store('fakultas', 'public');

        Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
            'dekan' => $request->dekan,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('fakultas.index')->with('success', 'Data berhasil ditambahkan');
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
    public function edit(Fakultas $fakultas)
    {
        return view('page.fakultas.edit', compact('fakultas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fakultas = Fakultas::findOrFail($id);

        $data = $request->only('nama_fakultas', 'dekan', 'deskripsi');

        if ($request->hasFile('file')) {
            if ($fakultas->file) {
                Storage::disk('public')->delete($fakultas->file);
            }

            $data['file'] = $request->file('file')->store('fakultas', 'public');
        }


        $fakultas->update($data);

        return redirect()->route('fakultas.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        if ($fakultas->file) {
            Storage::delete($fakultas->file);
        }
        $fakultas->delete();

        return redirect()->route('fakultas.index')->with('success', 'Data berhasil dihapus');
    }
}
