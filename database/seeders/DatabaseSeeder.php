<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SEED KATEGORI (Sesuai UU No. 11/2010 & Permen)
        $kategori = ['Benda', 'Bangunan', 'Struktur', 'Situs', 'Kawasan'];
        foreach ($kategori as $k) {
            DB::table('kategori_budaya')->insert([
                'nama_kategori' => $k,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. SEED WILAYAH (Provinsi Maluku & 11 Kab/Kota)
        $wilayah = [
            ['kode' => '81', 'nama' => 'Provinsi Maluku', 'tingkat' => 'Provinsi'],
            ['kode' => '81.01', 'nama' => 'Kab. Maluku Tengah', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.02', 'nama' => 'Kab. Maluku Tenggara', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.03', 'nama' => 'Kab. Kepulauan Tanimbar', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.04', 'nama' => 'Kab. Buru', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.05', 'nama' => 'Kab. Kepulauan Aru', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.06', 'nama' => 'Kab. Seram Bagian Barat', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.07', 'nama' => 'Kab. Seram Bagian Timur', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.08', 'nama' => 'Kab. Maluku Barat Daya', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.09', 'nama' => 'Kab. Buru Selatan', 'tingkat' => 'Kabupaten'],
            ['kode' => '81.71', 'nama' => 'Kota Ambon', 'tingkat' => 'Kota'],
            ['kode' => '81.72', 'nama' => 'Kota Tual', 'tingkat' => 'Kota'],
        ];

        foreach ($wilayah as $w) {
            DB::table('wilayah')->insert($w);
        }

        // 3. SEED USER (Super Admin & Evaluator Provinsi)
        User::create([
            'name' => 'Super Admin Prov',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'peran' => 'super_admin',
            'kode_wilayah' => '81',
        ]);

        User::create([
            'name' => 'Evaluator TACB',
            'email' => 'evaluator@mail.com',
            'password' => Hash::make('password'),
            'peran' => 'evaluator',
            'kode_wilayah' => '81',
        ]);

        // 4. SEED USER PER KABUPATEN/KOTA
        foreach ($wilayah as $w) {
            if ($w['tingkat'] != 'Provinsi') {
                $slug = strtolower(str_replace([' ', '.'], '', $w['nama']));
                User::create([
                    'name' => 'Admin ' . $w['nama'],
                    'email' => $slug . '@mail.com', // Contoh: kotaambon@mail.com
                    'password' => Hash::make('password'),
                    'peran' => 'admin_kabupaten',
                    'kode_wilayah' => $w['kode'],
                ]);
            }
        }
    }
}
