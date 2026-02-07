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
        Schema::create('evaluasi_cagar_budaya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cagar_budaya_id')->constrained('cagar_budaya')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users');
            $table->timestamp('tanggal_evaluasi')->useCurrent();
            $table->text('catatan');
            $table->enum('kesimpulan', ['Layak', 'Tidak Layak', 'Perlu Revisi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_cagar_budaya');
    }
};
