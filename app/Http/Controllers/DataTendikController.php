<?php

namespace App\Http\Controllers;

use App\Models\DataTendik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataTendikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_tendik = DataTendik::paginate(10);
        return view('page.data_tendik.index', compact('data_tendik'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tendik' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string',
            'status_kepegawaian' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Simpan foto ke storage/public/tendik
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('tendik', 'public');
        }

        // Simpan data ke database
        DataTendik::create([
            'nama_tendik' => $request->nama_tendik,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'status_kepegawaian' => $request->status_kepegawaian,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('data_tendik.index')->with('success', 'Data Tendik berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tendik = DataTendik::findOrFail($id);

        $request->validate([
            'nama_tendik' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string',
            'status_kepegawaian' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Update foto jika ada file baru
        if ($request->hasFile('foto')) {
            if ($tendik->foto && Storage::disk('public')->exists($tendik->foto)) {
                Storage::disk('public')->delete($tendik->foto);
            }
            $tendik->foto = $request->file('foto')->store('tendik', 'public');
        }

        // Update data lainnya
        $tendik->update([
            'nama_tendik' => $request->nama_tendik,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'status_kepegawaian' => $request->status_kepegawaian,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan,
            'foto' => $tendik->foto,
        ]);

        return redirect()->route('data_tendik.index')->with('success', 'Data Tendik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tendik = DataTendik::findOrFail($id);

        if ($tendik->foto && Storage::disk('public')->exists($tendik->foto)) {
            Storage::disk('public')->delete($tendik->foto);
        }

        $tendik->delete();

        return redirect()->back()->with('success', 'Data Tendik berhasil dihapus.');
    }
}
