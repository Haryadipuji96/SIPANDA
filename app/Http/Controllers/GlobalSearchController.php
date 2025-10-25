<?php

namespace App\Http\Controllers;

use App\Models\DataSarpras;
use App\Models\DataTendik;
use App\Models\DokumenBa;
use Illuminate\Http\Request;
use App\Models\FakultasSyariah;
use App\Models\DokumenEkonomi;
use App\Models\DokumenHtn;
use App\Models\DokumenMou_MPI;
use App\Models\DokumenMoU_PIAUD;
use App\Models\DokumenMouInstitutIAIT;
use App\Models\DokumenMouPAI;
use App\Models\DokumenMouPascasarjana;
use App\Models\DokumenMouPGMI;
use App\Models\DokumenPeraturan;
use App\Models\DokumenSkInstitusi;
use App\Models\DokumenSkMahasiswa;
use App\Models\DokumenSt;
use App\Models\Fakultas;
use App\Models\FakultasTarbiyah;
use App\Models\HKI;
use App\Models\ProdiBkpi;
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
        $allItems = FakultasSyariah::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $fakultas_syariahs = FakultasSyariah::where('nama_fakultas', 'like', "%$query%")
            ->orWhere('dekan', 'like', "%$query%")
            ->orWhere('deskripsi', 'like', "%$query%")
            ->get(['id', 'nama_fakultas as title', 'dekan as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                // cari posisi index
                $index = $allItems->search($item->id);
                // hitung halaman keberapa data itu muncul
                $page = ceil(($index + 1) / $perPage);

                $item->link = route('fakultas_syariahs.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'FAKULTAS SYARIAH';
                return $item;
            });


        $allItems = Fakultas::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $fakultas = Fakultas::where('nama_fakultas', 'like', "%$query%")
            ->orWhere('dekan', 'like', "%$query%")
            ->orWhere('deskripsi', 'like', "%$query%")
            ->get(['id', 'nama_fakultas as title', 'dekan as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                // cari posisi index
                $index = $allItems->search($item->id);
                // hitung halaman keberapa data itu muncul
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('fakultas.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'FAKULTAS';
                return $item;
            });

        $allItems = DokumenEkonomi::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen = DokumenEkonomi::where('judul', 'like', "%$query%")
            ->orWhere('kategori', 'like', "%$query%")
            ->orWhere('deskripsi', 'like', "%$query%")
            ->get(['id', 'judul as title', 'kategori as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen-ekonomi.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'EKONOMI';
                return $item;
            });

        $allItems = DataTendik::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $data_tendik = DataTendik::where('nama_tendik', 'like', "%$query%")
            ->orWhere('nip', 'like', "%$query%")
            ->orWhere('jabatan', 'like', "%$query%")
            ->get(['id', 'nama_tendik as title', 'nip as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('data_tendik.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'DATA TENDIK';
                return $item;
            });

        $allItems = HKI::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $hki = HKI::where('nama_dokumen_Kegiatan', 'like', "%$query%")
            ->orWhere('tahun', 'like', "%$query%")
            ->orWhere('fakultas', 'like', "%$query%")
            ->get(['id', 'nama_dokumen_kegiatan as title', 'tahun as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('data_tendik.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'HKI';
                return $item;
            });

        $allItems = DokumenHtn::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_htn = DokumenHtn::where('judul_mou', 'like', "%$query%")
            ->orWhere('lembaga_mitra', 'like', "%$query%")
            ->orWhere('kategori', 'like', "%$query%")
            ->get(['id', 'judul_mou as title', 'lembaga_mitra as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_htn.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'HTN';
                return $item;
            });

        $allItems = ProdiBkpi::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $data = ProdiBkpi::where('judul_mou', 'like', "%$query%")
            ->orWhere('mitra_kerjasama', 'like', "%$query%")
            ->orWhere('nomor_dokumen', 'like', "%$query%")
            ->get(['id', 'judul_mou as title', 'mitra_kerjasama as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('prodi_bkpi.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'BKPI';
                return $item;
            });

        $allItems = FakultasTarbiyah::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $fakultas_tarbiyah = FakultasTarbiyah::where('judul_mou', 'like', "%$query%")
            ->orWhere('mitra_kerjasama', 'like', "%$query%")
            ->orWhere('nomor_dokumen', 'like', "%$query%")
            ->get(['id', 'judul_mou as title', 'mitra_kerjasama as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('fakultas_tarbiyah.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'FAKULTAS TARBIYAH';
                return $item;
            });

        $allItems = DokumenMou_MPI::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_mpi = DokumenMou_MPI::where('judul_dokumen', 'like', "%$query%")
            ->orWhere('nomor_mou', 'like', "%$query%")
            ->orWhere('tanggal_mou', 'like', "%$query%")
            ->get(['id', 'judul_dokumen as title', 'nomor_mou as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_mpi.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'MPI';
                return $item;
            });

        $allItems = DokumenMoU_PIAUD::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_piaud = DokumenMoU_PIAUD::where('judul_dokumen', 'like', "%$query%")
            ->orWhere('nomor_mou', 'like', "%$query%")
            ->orWhere('tanggal_mou', 'like', "%$query%")
            ->get(['id', 'judul_dokumen as title', 'nomor_mou as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_piaud.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'PIAUD';
                return $item;
            });

        $allItems = DokumenMouPAI::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_pai = DokumenMouPAI::where('judul_dokumen', 'like', "%$query%")
            ->orWhere('nomor_mou', 'like', "%$query%")
            ->orWhere('tanggal_mou', 'like', "%$query%")
            ->get(['id', 'judul_dokumen as title', 'nomor_mou as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_pai.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'PAI';
                return $item;
            });

        $allItems = DokumenMouPGMI::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_pgmi = DokumenMouPGMI::where('judul_dokumen', 'like', "%$query%")
            ->orWhere('nomor_mou', 'like', "%$query%")
            ->orWhere('tanggal_mou', 'like', "%$query%")
            ->get(['id', 'judul_dokumen as title', 'nomor_mou as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_pgmi.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'PGMI';
                return $item;
            });

        $allItems = DokumenMouInstitutIAIT::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_iait = DokumenMouInstitutIAIT::where('judul_mou', 'like', "%$query%")
            ->orWhere('nomor_mou', 'like', "%$query%")
            ->orWhere('lembaga_mitra', 'like', "%$query%")
            ->get(['id', 'judul_mou as title', 'nomor_mou as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_iait.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'MOU INSTITUT IAIT';
                return $item;
            });

        $allItems = DokumenMouPascasarjana::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_pascasarjana = DokumenMouPascasarjana::where('judul_mou', 'like', "%$query%")
            ->orWhere('nomor_mou', 'like', "%$query%")
            ->orWhere('lembaga_mitra', 'like', "%$query%")
            ->get(['id', 'judul_mou as title', 'nomor_mou as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_pascasarjana.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'MOU PASCASARJANA';
                return $item;
            });

        $allItems = DokumenSkInstitusi::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_sk_institusi = DokumenSkInstitusi::where('judul', 'like', "%$query%")
            ->orWhere('nomor_sk', 'like', "%$query%")
            ->orWhere('tanggal_sk', 'like', "%$query%")
            ->get(['id', 'judul as title', 'nomor_sk as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_sk_institusi.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'SK INSTITUSI';
                return $item;
            });

        $allItems = DokumenSkMahasiswa::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_sk_mahasiswa = DokumenSkMahasiswa::where('judul', 'like', "%$query%")
            ->orWhere('nomor_sk', 'like', "%$query%")
            ->orWhere('tanggal_sk', 'like', "%$query%")
            ->get(['id', 'judul as title', 'nomor_sk as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_sk_mahasiswa.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'SK MAHASISWA';
                return $item;
            });

        $allItems = DokumenSt::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_st = DokumenSt::where('judul', 'like', "%$query%")
            ->orWhere('nomor_st', 'like', "%$query%")
            ->orWhere('tanggal_st', 'like', "%$query%")
            ->get(['id', 'judul as title', 'nomor_st as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_st.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'DOKUMEN ST';
                return $item;
            });

        $allItems = DokumenBa::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_ba = DokumenBa::where('judul', 'like', "%$query%")
            ->orWhere('nomor_ba', 'like', "%$query%")
            ->orWhere('tanggal_ba', 'like', "%$query%")
            ->get(['id', 'judul as title', 'nomor_ba as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_ba.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'DOKUMEN BA';
                return $item;
            });

        $allItems = DataSarpras::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $data_sarpras = DataSarpras::where('nama_barang', 'like', "%$query%")
            ->orWhere('kategori', 'like', "%$query%")
            ->orWhere('lokasi', 'like', "%$query%")
            ->get(['id', 'nama_barang as title', 'kategori as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('data_sarpras.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'DATA SARPRAS';
                return $item;
            });

        $allItems = DokumenPeraturan::orderBy('id', 'asc')->pluck('id');
        $perPage = 10;
        $dokumen_peraturan = DokumenPeraturan::where('judul', 'like', "%$query%")
            ->orWhere('nomor_peraturan', 'like', "%$query%")
            ->orWhere('kategori', 'like', "%$query%")
            ->get(['id', 'judul as title', 'nomor_peraturan as detail'])
            ->map(function ($item) use ($allItems, $perPage) {
                $index = $allItems->search($item->id);
                $page = ceil(($index + 1) / $perPage);
                $item->link = route('dokumen_peraturan.index', [
                    'page' => $page,
                    'highlight_id' => $item->id
                ]);
                $item->category = 'DOKUMEN PERATURAN';
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
            ->merge($data)
            ->merge($fakultas_tarbiyah)
            ->merge($dokumen_mpi)
            ->merge($dokumen_piaud)
            ->merge($dokumen_pai)
            ->merge($dokumen_pgmi)
            ->merge($dokumen_iait)
            ->merge($dokumen_pascasarjana)
            ->merge($dokumen_sk_institusi)
            ->merge($dokumen_sk_mahasiswa)
            ->merge($dokumen_st)
            ->merge($dokumen_ba)
            ->merge($data_sarpras)
            ->merge($dokumen_peraturan)
            ->merge($users);

        // 🔹 Tampilkan hasil di view (folder page)
        return view('page.search.result', [
            'results' => $results,
            'query' => $query,
        ]);
    }
}
