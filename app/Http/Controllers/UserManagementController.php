<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // Index sudah Anda buat (pastikan filter where peran = admin_kabupaten tetap ada)
    public function index()
    {
        $users = User::with('wilayah')
            ->where('peran', 'admin_kabupaten')
            ->orderBy('created_at', 'desc')
            ->get();
        $listWilayah = Wilayah::all();
        return view('user-admin.user-management.index', compact('users', 'listWilayah'));
    }

    /**
     * STORE: Menyimpan User Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8',
            'peran'        => 'required|in:admin_kabupaten,evaluator,super_admin',
            'kode_wilayah' => 'required_if:peran,admin_kabupaten',
        ], [
            'kode_wilayah.required_if' => 'Wilayah wajib dipilih untuk Admin Kabupaten.'
        ]);

        try {
            User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'password'     => Hash::make($request->password),
                'peran'        => $request->peran,
                'kode_wilayah' => ($request->peran === 'admin_kabupaten') ? $request->kode_wilayah : null,
            ]);

            return back()->with('success', 'Akun admin berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data: ' . $e->getMessage());
        }
    }

    /**
     * SHOW: Mengambil data untuk AJAX Edit
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * UPDATE: Memperbarui Data User
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'peran'        => 'required|in:admin_kabupaten,evaluator,super_admin',
            'kode_wilayah' => 'required_if:peran,admin_kabupaten',
            'password'     => 'nullable|min:8', // Nullable karena boleh tidak ganti pass
        ]);

        try {
            $data = [
                'name'         => $request->name,
                'email'        => $request->email,
                'peran'        => $request->peran,
                'kode_wilayah' => ($request->peran === 'admin_kabupaten') ? $request->kode_wilayah : null,
            ];

            // Update password hanya jika kolom password diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return back()->with('success', 'Data akun berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * DESTROY: Menghapus User
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Keamanan tambahan: Jangan hapus diri sendiri
            if ($user->id === auth()->id()) {
                return back()->with('error', 'Anda tidak diperbolehkan menghapus akun sendiri.');
            }

            $user->delete();
            return back()->with('success', 'Akun berhasil dihapus selamanya.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
