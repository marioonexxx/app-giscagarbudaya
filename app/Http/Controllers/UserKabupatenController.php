<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use Illuminate\Http\Request;

class UserKabupatenController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Pastikan hanya admin_kabupaten yang bisa akses (jika tidak pakai middleware)
        if ($user->peran !== 'admin_kabupaten') {
            abort(403, 'Akses terbatas hanya untuk Admin Kabupaten.');
        }

        // Filter Query: Kunci data hanya untuk wilayah kabupaten yang sedang login
        $queryWilayah = CagarBudaya::where('kode_wilayah', $user->kode_wilayah);

        // Hitung Counter berdasarkan status (Clone query agar filter wilayah tetap terkunci)
        $countPendaftaran  = (clone $queryWilayah)->where('status_verifikasi', 'Pendaftaran')->count();
        $countDiverifikasi = (clone $queryWilayah)->where('status_verifikasi', 'Diverifikasi')->count();
        $countDitetapkan   = (clone $queryWilayah)->where('status_verifikasi', 'Ditetapkan')->count();
        $countDitolak      = (clone $queryWilayah)->where('status_verifikasi', 'Ditolak')->count();

        // Ambil 5 data terbaru yang baru diinput di kabupaten ini
        $recentUpdates = (clone $queryWilayah)->latest()->take(5)->get();

        return view('user-kabupaten.dashboard', compact(
            'countPendaftaran',
            'countDiverifikasi',
            'countDitetapkan',
            'countDitolak',
            'recentUpdates'
        ));
    }
}
