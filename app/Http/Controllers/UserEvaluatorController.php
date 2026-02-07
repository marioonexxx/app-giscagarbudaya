<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use Illuminate\Http\Request;

class UserEvaluatorController extends Controller
{
    public function index()
    {
        // Gunakan with() untuk eager loading agar tidak error saat memanggil $item->kategori atau $item->foto
        $query = CagarBudaya::query();
        $antreanVerifikasi = (clone $query)->where('status_verifikasi', 'Pendaftaran')->count();
        $totalSelesai = (clone $query)->whereIn('status_verifikasi', ['Diverifikasi', 'Ditetapkan'])->count();
        $totalDitolak = (clone $query)->where('status_verifikasi', 'Ditolak')->count();
        $totalRevisi = CagarBudaya::where('status_verifikasi', 'Revisi')->count();

        // 4. Ambil 5 tugas terbaru dengan relasi agar tidak error di loop Blade
        $tugasTerbaru = CagarBudaya::with(['kategori', 'foto', 'user'])
            ->where('status_verifikasi', 'Pendaftaran')
            ->latest()
            ->take(5)
            ->get();

        return view('user-evaluator.dashboard', compact(
            'antreanVerifikasi',
            'totalSelesai',
            'totalDitolak',
            'tugasTerbaru',
            'totalRevisi',
        ));
    }
}
