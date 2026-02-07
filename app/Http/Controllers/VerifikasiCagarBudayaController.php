<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\EvaluasiCagarBudaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiCagarBudayaController extends Controller
{
    // Menampilkan halaman detail (tetap seperti sebelumnya)
    public function show($id)
    {
        $cagar = CagarBudaya::with(['foto', 'kategori', 'evaluasi.evaluator'])->findOrFail($id);
        return view('user-evaluator.verifikasi.show', compact('cagar')); // Sesuaikan nama view kamu
    }

    // Method untuk SETUJU (Layak)
    public function setujui(Request $request, $id)
    {
        return $this->prosesEvaluasi($request, $id, 'Layak', 'Diverifikasi');
    }

    // Method untuk TOLAK / REVISI
    // Karena di Blade tadi ada 'Perlu Revisi' dan 'Tidak Layak',
    // kita handle di sini berdasarkan input kesimpulan dari modal.
    public function tolak(Request $request, $id)
    {
        $statusMapping = [
            'Perlu Revisi' => 'Revisi',
            'Tidak Layak'  => 'Ditolak'
        ];

        return $this->prosesEvaluasi(
            $request,
            $id,
            $request->kesimpulan, // 'Perlu Revisi' atau 'Tidak Layak'
            $statusMapping[$request->kesimpulan] ?? 'Ditolak'
        );
    }

    /**
     * Helper Fungsi agar kode tidak berulang (DRY Principle)
     */
    private function prosesEvaluasi($request, $id, $kesimpulan, $statusBaru)
    {
        $request->validate([
            'catatan' => 'required|string|min:10',
        ]);

        $cagar = CagarBudaya::findOrFail($id);

        try {
            DB::beginTransaction();

            // 1. Catat ke Riwayat Evaluasi
            EvaluasiCagarBudaya::create([
                'cagar_budaya_id' => $cagar->id,
                'evaluator_id'    => Auth::id(),
                'tanggal_evaluasi' => now(),
                'catatan'         => $request->catatan,
                'kesimpulan'      => $kesimpulan,
            ]);

            // 2. Update Status Tabel Utama
            $cagar->update(['status_verifikasi' => $statusBaru]);

            DB::commit();
            return redirect()->route('evaluator.dashboard')->with('success', 'Status berhasil diperbarui menjadi ' . $statusBaru);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function riwayatEvaluasi()
    {
        // Menggunakan 'wilayah' sesuai nama fungsi di Model kamu
        $dataCagar = CagarBudaya::with(['evaluasi.evaluator', 'kategori', 'wilayah'])
            ->whereNotIn('status_verifikasi', ['Pendaftaran'])
            ->latest()
            ->get();

        return view('user-evaluator.verifikasi.riwayat', compact('dataCagar'));
    }
}
