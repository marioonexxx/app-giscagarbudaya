<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use Illuminate\Http\Request;

class PetaSebaranController extends Controller
{
    public function index()
    {
        // Ambil kode_wilayah dari admin yang sedang login
        $kodeWilayah = auth()->user()->kode_wilayah;

        // Hanya ambil data yang sesuai dengan wilayah admin tersebut
        $sebaran = CagarBudaya::where('kode_wilayah', $kodeWilayah)->get();

        return view('user-kabupaten.peta-sebaran.index', compact('sebaran'));
    }
}
