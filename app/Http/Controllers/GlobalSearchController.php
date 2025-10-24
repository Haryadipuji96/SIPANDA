<?php

namespace App\Http\Controllers;

use App\Models\DataTendik;
use Illuminate\Http\Request;
use App\Models\FakultasSyariah;
use App\Models\DokumenEkonomi;
use App\Models\DokumenHtn;
use App\Models\Fakultas;
use App\Models\HKI;
use App\Models\User;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $results = collect(); // pakai koleksi kosong supaya aman

        // Jika keyword kosong, langsung tampilkan view kosong
        if (!$query) {
            return view('page.search.result', [
                'results' => $results,
                'query' => $query,
            ]);
        }

        // 🔹 Pencarian di Fakultas Syariah
        $fakultas_syariahs = FakultasSyariah::where('nama_fakultas', 'like', "%$query%")
            ->orWhere('dekan', 'like', "%$query%")
            ->orWhere('deskripsi', 'like', "%$query%")
            ->get(['id', 'nama_fakultas as title', 'dekan as detail'])
            ->map(function ($item) {
                $item->link = route('fakultas_syariahs.index', ['highlight_id' => $item->id]);
                $item->category = 'Fakultas Syariah';
                return $item;
            });

        $fakultas = Fakultas::where('nama_fakultas', 'like', "%$query%")
            ->orWhere('dekan', 'like', "%$query%")
            ->orWhere('deskripsi', 'like', "%$query%")
            ->get(['id', 'nama_fakultas as title', 'dekan as detail'])
            ->map(function ($item) {
                $item->link = route('fakultas.index', ['highlight_id' => $item->id]);
                $item->category = 'Fakultas';
                return $item;
            });

        $dokumen = DokumenEkonomi::where('judul', 'like', "%$query%")
            ->orWhere('kategori', 'like', "%$query%")
            ->orWhere('deskripsi', 'like', "%$query%")
            ->get(['id', 'judul as title', 'kategori as detail'])
            ->map(function ($item) {
                $item->link = route('dokumen-ekonomi.index', ['highlight_id' => $item->id]);
                $item->category = 'Ekonomi';
                return $item;
            });

        $data_tendik = DataTendik::where('nama_tendik', 'like', "%$query%")
            ->orWhere('nip', 'like', "%$query%")
            ->orWhere('jabatan', 'like', "%$query%")
            ->get(['id', 'nama_tendik as title', 'nip as detail'])
            ->map(function ($item) {
                $item->link = route('data_tendik.index', ['highlight_id' => $item->id]);
                $item->category = 'Data Tendik';
                return $item;
            });

        $hki = HKI::where('nama_dokumen_Kegiatan', 'like', "%$query%")
            ->orWhere('tahun', 'like', "%$query%")
            ->orWhere('fakultas', 'like', "%$query%")
            ->get(['id', 'nama_dokumen_kegiatan as title', 'tahun as detail'])
            ->map(function ($item) {
                $item->link = route('hki.index', ['highlight_id' => $item->id]);
                $item->category = 'HKI';
                return $item;
            });

        $dokumen_htn = DokumenHtn::where('judul_mou', 'like', "%$query%")
            ->orWhere('lembaga_mitra', 'like', "%$query%")
            ->orWhere('kategori', 'like', "%$query%")
            ->get(['id', 'judul_mou as title', 'lembaga_mitra as detail'])
            ->map(function ($item) {
                $item->link = route('dokumen_htn.index', ['highlight_id' => $item->id]);
                $item->category = 'HTN';
                return $item;
            });

        // 🔹 Pencarian di User/Admin
        $users = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->get(['id', 'name as title', 'email as detail'])
            ->map(function ($item) {
                $item->link = route('users.index');
                $item->category = 'User/Admin';
                return $item;
            });

        // 🔹 Gabungkan semua hasil pencarian
        $results = $results->merge($fakultas_syariahs)
            ->merge($fakultas)
            ->merge($dokumen)
            ->merge($data_tendik)
            ->merge($hki)
            ->merge($dokumen_htn)
            ->merge($users);

        // 🔹 Tampilkan hasil di view (folder page)
        return view('page.search.result', [
            'results' => $results,
            'query' => $query,
        ]);
    }
}
