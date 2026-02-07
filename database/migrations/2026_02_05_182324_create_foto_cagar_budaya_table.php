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
        Schema::create('foto_cagar_budaya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cagar_budaya_id')->constrained('cagar_budaya')->onDelete('cascade');
            $table->string('path'); // Lokasi file di storage
            $table->string('keterangan')->nullable(); // Opsional: misal "Tampak Depan"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_cagar_budaya');
    }
};
