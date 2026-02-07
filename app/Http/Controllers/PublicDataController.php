<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class PublicDataController extends Controller
{

    public function index()
    {
        // Mengambil data yang statusnya 'Diverifikasi' ATAU 'Ditetapkan'
        $jumlahTerverifikasi = CagarBudaya::whereIn('status_verifikasi', ['Diverifikasi', 'Ditetapkan'])->count();
        // 2. Hitung Jumlah Evaluator (TACB Ahli)
        $jumlahEvaluator = User::where('peran', 'evaluator')->count();
        return view('welcome', compact('jumlahTerverifikasi', 'jumlahEvaluator'));
    }


    // Menampilkan halaman Peta
    public function peta()
    {
        $kabupaten = Wilayah::orderBy('nama', 'asc')->get();

        // Ambil data awal untuk render pertama kali (Default: Semua yang terverifikasi)
        $sebaran = CagarBudaya::with(['kategori', 'wilayah'])
            ->whereIn('status_verifikasi', ['Diverifikasi', 'Ditetapkan'])
            ->get();

        return view('peta', compact('kabupaten', 'sebaran'));
    }

    public function apiStatistik(Request $request)
    {
        // Mengambil data yang statusnya 'Diverifikasi' ATAU 'Ditetapkan'
        $query = CagarBudaya::with(['kategori', 'wilayah'])
            ->whereIn('status_verifikasi', ['Diverifikasi', 'Ditetapkan']);

        // Filter berdasarkan kode_wilayah
        if ($request->has('wilayah_kode') && $request->wilayah_kode != '') {
            $query->where('kode_wilayah', $request->wilayah_kode);
        }

        $data = $query->get();

        return response()->json($data);
    }


    /**
     * Menampilkan halaman statistik utama
     */
    public function statistik()
    {
        // Ambil wilayah tingkat Kabupaten dan Kota untuk dropdown filter
        $kabupatens = Wilayah::whereIn('tingkat', ['Kabupaten', 'Kota'])
            ->orderBy('nama', 'ASC')
            ->get();

        return view('statistik', compact('kabupatens'));
    }

    /**
     * Mengambil data cagar budaya yang sudah diverifikasi (untuk AJAX Tabel)
     */
    public function getStatistik(Request $request)
    {
        // Eager loading relasi 'wilayah' (sesuai fungsi di model Anda)
        $query = CagarBudaya::with(['kategori', 'wilayah'])
            ->where('status_verifikasi', 'Diverifikasi');

        // Filter menggunakan kolom 'kode_wilayah' sesuai foreign key di model Anda
        if ($request->has('wilayah_kode') && $request->wilayah_kode != '') {
            $query->where('kode_wilayah', $request->wilayah_kode);
        }

        $data = $query->latest()->get();

        return response()->json($data);
    }

    /**
     * Mengambil detail satu objek (untuk AJAX Modal)
     */
    public function getDetail($id)
    {
        // Load relasi foto untuk galeri di modal
        $cagar = CagarBudaya::with(['kategori', 'wilayah', 'foto'])->findOrFail($id);

        return response()->json([
            'nama' => $cagar->nama,
            'kategori' => $cagar->kategori->nama_kategori ?? '-',
            'wilayah' => $cagar->wilayah->nama ?? '-', // Mengambil nama dari relasi wilayah()
            'alamat' => $cagar->alamat_lengkap ?? 'Alamat tidak tersedia',
            'deskripsi' => $cagar->deskripsi ?? 'Tidak ada deskripsi singkat.',
            'foto' => $cagar->foto->map(function ($f) {
                return asset('storage/' . $f->path);
            })
        ]);
    }
}
