<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cagar_budaya', function (Blueprint $table) {
            $table->id();

            // ==========================================
            // 1. RELASI UTAMA
            // ==========================================
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_budaya');

            // Relasi Wilayah
            $table->string('kode_wilayah');
            $table->foreign('kode_wilayah')->references('kode')->on('wilayah');

            // ==========================================
            // 2. DATA IDENTITAS OBJEK
            // ==========================================
            $table->string('nama');
            $table->string('kode_regnas')->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('alamat_lengkap')->nullable();

            // ==========================================
            // 3. DOKUMEN USULAN (DARI KABUPATEN)
            // ==========================================
            $table->string('file_surat_pengantar')->nullable();
            $table->string('file_rekomendasi_tacb')->nullable();


            // ==========================================
            // 4. STATUS & PENETAPAN (PROVINSI/NASIONAL)
            // ==========================================
            $table->enum('status_verifikasi', [
                'Pendaftaran',  // Baru diinput (ODCB)
                'Diverifikasi', // Dokumen diperiksa admin prov
                'Revisi',       // Butuh perbaikan dari Kabupaten (Sinkron dengan Evaluasi)
                'Ditetapkan',   // Sudah terbit SK Gubernur
                'Ditolak'       // Tidak memenuhi syarat
            ])->default('Pendaftaran');

            $table->enum('peringkat', ['Nasional', 'Provinsi', 'Kabupaten/Kota'])->nullable();

            // Detail SK Penetapan
            $table->string('nomor_sk')->nullable();
            $table->string('file_sk_penetapan')->nullable();
            $table->year('tahun_penetapan')->nullable();

            // ==========================================
            // 5. DATA SPASIAL (GIS)
            // ==========================================
            $table->enum('tipe_geometri', ['Titik', 'Poligon']);
            $table->json('koordinat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cagar_budaya');
    }
};
