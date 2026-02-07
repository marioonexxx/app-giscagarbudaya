<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use Illuminate\Http\Request;

class PetaSebaranController extends Controller
{
    public function index()
    {
        // Kita ambil semua, termasuk yang statusnya masih 'Pendaftaran'
        $sebaran = CagarBudaya::all();
        return view('user-kabupaten.peta-sebaran.index', compact('sebaran'));
    }
}
