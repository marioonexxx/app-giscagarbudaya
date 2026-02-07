<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use Illuminate\Http\Request;

class VerifikasiCagarBudayaController extends Controller
{
    /**
     * Menampilkan detail data untuk diperiksa oleh evaluator
     */
    public function show($id)
    {
        // Eager load relasi agar tidak error di blade
        $cagar = CagarBudaya::with(['kategori', 'foto', 'user'])->findOrFail($id);

        return view('user-evaluator.verifikasi.show', compact('cagar'));
    }

    public function setujui($id)
    {
        $cagar = CagarBudaya::findOrFail($id);
        $cagar->update(['status_verifikasi' => 'Diverifikasi']);

        return redirect()->route('evaluator.dashboard')
            ->with('success', 'Data berhasil diverifikasi oleh Evaluator.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_evaluator' => 'required|string|min:5'
        ]);

        $cagar = CagarBudaya::findOrFail($id);
        $cagar->update([
            'status_verifikasi' => 'Ditolak',
            'catatan_evaluator' => $request->catatan_evaluator
        ]);

        return redirect()->route('user-evaluator.dashboard')
            ->with('info', 'Data dikembalikan untuk revisi.');
    }
}
