<?php

namespace App\Http\Controllers;

use App\Models\CagarBudaya;
use App\Models\KategoriBudaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InputCagarBudayaController extends Controller
{
    public function index()
    {
        // Mengambil data usulan milik user yang sedang login saja
        // Kita gunakan eager loading 'kategori' agar tidak berat (N+1 Query)
        $cagarBudaya = CagarBudaya::with('kategori')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user-kabupaten.cagar-budaya.show', compact('cagarBudaya'));
    }

    public function create()
    {
        // Menggunakan variabel singular $kategori sesuai permintaanmu
        $kategori = KategoriBudaya::all();

        return view('user-kabupaten.cagar-budaya.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_budaya,id',
            'tipe_geometri' => 'required',
            'koordinat' => 'required',
            'foto_upload.*' => 'image|max:2048',
            // Tambahkan validasi file PDF pendukung
            'file_surat_pengantar' => 'nullable|mimes:pdf|max:5120',
            'file_rekomendasi_tacb' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Proses Upload Dokumen PDF
        $pathPengantar = $request->hasFile('file_surat_pengantar')
            ? $request->file('file_surat_pengantar')->store('dokumen_usulan', 'public')
            : null;

        $pathRekomendasi = $request->hasFile('file_rekomendasi_tacb')
            ? $request->file('file_rekomendasi_tacb')->store('dokumen_usulan', 'public')
            : null;

        $cb = CagarBudaya::create([
            'user_id'           => auth()->id(),
            'kategori_id'       => $request->kategori_id,
            'kode_wilayah'      => auth()->user()->kode_wilayah,
            'nama'              => $request->nama,
            'deskripsi'         => $request->deskripsi,
            'alamat_lengkap'    => $request->alamat_lengkap,
            'tipe_geometri'     => $request->tipe_geometri,
            'koordinat'         => json_decode($request->koordinat),
            'status_verifikasi' => 'Pendaftaran',
            // Simpan path PDF ke database
            'file_surat_pengantar'  => $pathPengantar,
            'file_rekomendasi_tacb' => $pathRekomendasi,
        ]);

        // Simpan banyak foto (Logic lama tetap dipertahankan)
        if ($request->hasFile('foto_upload')) {
            foreach ($request->file('foto_upload') as $index => $file) {
                $path = $file->store('cagar-budaya/foto', 'public');
                $cb->foto()->create([
                    'path' => $path,
                    'keterangan' => $file->getClientOriginalName() // Gunakan nama asli file sesuai keinginanmu
                ]);
            }
        }

        return redirect()->route('admin_kabupaten.cagar-budaya.index')
            ->with('success', 'Usulan Cagar Budaya berhasil dikirim ke Provinsi!');
    }

    public function edit($id)
    {
        $cagarBudaya = CagarBudaya::with('foto')->findOrFail($id);
        $kategori = KategoriBudaya::all();
        return view('user-kabupaten.cagar-budaya.edit', compact('cagarBudaya', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $cb = CagarBudaya::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_budaya,id',
            'tipe_geometri' => 'required|in:Titik,Poligon',
            'koordinat' => 'required',
            'foto_upload.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'file_surat_pengantar' => 'nullable|mimes:pdf|max:5120',
            'file_rekomendasi_tacb' => 'nullable|mimes:pdf|max:5120',
        ]);

        // 1. Logika Perubahan Status (SANGAT PENTING)
        // Jika status saat ini adalah 'Revisi', kembalikan ke 'Pendaftaran'
        if ($cb->status_verifikasi === 'Revisi') {
            $cb->status_verifikasi = 'Pendaftaran';
        }

        // 2. Update Data Utama
        $cb->nama = $request->nama;
        $cb->kategori_id = $request->kategori_id;
        $cb->deskripsi = $request->deskripsi;
        $cb->alamat_lengkap = $request->alamat_lengkap;
        $cb->tipe_geometri = $request->tipe_geometri;
        $cb->koordinat = json_decode($request->koordinat);

        // 3. Update Dokumen PDF (Hapus lama jika ada yang baru)
        if ($request->hasFile('file_surat_pengantar')) {
            if ($cb->file_surat_pengantar) Storage::disk('public')->delete($cb->file_surat_pengantar);
            $cb->file_surat_pengantar = $request->file('file_surat_pengantar')->store('dokumen_usulan', 'public');
        }

        if ($request->hasFile('file_rekomendasi_tacb')) {
            if ($cb->file_rekomendasi_tacb) Storage::disk('public')->delete($cb->file_rekomendasi_tacb);
            $cb->file_rekomendasi_tacb = $request->file('file_rekomendasi_tacb')->store('dokumen_usulan', 'public');
        }

        $cb->save();

        // 4. Update Foto (Opsional: Hapus lama dan ganti baru jika diupload)
        if ($request->hasFile('foto_upload')) {
            foreach ($cb->foto as $oldFoto) {
                Storage::disk('public')->delete($oldFoto->path);
                $oldFoto->delete();
            }

            foreach ($request->file('foto_upload') as $file) {
                $path = $file->store('cagar-budaya/foto', 'public');
                $cb->foto()->create([
                    'path' => $path,
                    'keterangan' => $file->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('admin_kabupaten.cagar-budaya.index')
            ->with('success', 'Perbaikan berhasil disimpan dan status usulan dikirim ulang ke Provinsi!');
    }

    public function destroy($id)
    {
        // 1. Cari data cagar budaya beserta relasi fotonya
        $cb = CagarBudaya::with('foto')->findOrFail($id);

        // 2. Hapus semua file fisik foto dari folder storage
        if ($cb->foto->isNotEmpty()) {
            foreach ($cb->foto as $foto) {
                // Cek apakah file benar-benar ada sebelum dihapus
                if (Storage::disk('public')->exists($foto->path)) {
                    Storage::disk('public')->delete($foto->path);
                }
            }
        }

        // 3. Hapus data dari database
        // Karena kita pakai hasMany, record di tabel foto_cagar_budaya
        // akan otomatis terhapus jika di migration kita pakai ->onDelete('cascade')
        // Jika tidak, kita hapus manual record fotonya dulu
        $cb->foto()->delete();
        $cb->delete();

        return redirect()
            ->route('admin_kabupaten.cagar-budaya.index')
            ->with('success', 'Data usulan dan semua foto terkait berhasil dihapus permanen!');
    }
}
