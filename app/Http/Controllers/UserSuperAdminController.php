<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use Illuminate\Http\Request;

class UserSuperAdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Mulai Query
        $query = CagarBudaya::query();
        // 2. Filter: Jika bukan super_admin, maka hanya ambil wilayah user tersebut
        // Khusus untuk admin_kabupaten dan evaluator (jika evaluator juga per wilayah)
        if ($user->peran !== 'super_admin') {
            $query->where('kode_wilayah', $user->kode_wilayah);
        }

        // 3. Eksekusi perhitungan jumlah (Counter)
        $countPendaftaran  = (clone $query)->where('status_verifikasi', 'Pendaftaran')->count();
        $countDiverifikasi = (clone $query)->where('status_verifikasi', 'Diverifikasi')->count();
        $countDitetapkan   = (clone $query)->where('status_verifikasi', 'Ditetapkan')->count();
        $countDitolak      = (clone $query)->where('status_verifikasi', 'Ditolak')->count();

        return view('user-admin.dashboard', compact(
            'countPendaftaran',
            'countDiverifikasi',
            'countDitetapkan',
            'countDitolak'
        ));
    }
}
