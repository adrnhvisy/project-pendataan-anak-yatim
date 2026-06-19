<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dokumen_anak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->cascadeOnDelete();
            $table->foreignId('kategori_dok_id')->constrained('kategori_dokumen')->restrictOnDelete();
            $table->string('file_path');
            $table->enum('status_verifikasi', ['Menunggu', 'Valid', 'Tidak Valid'])->default('Menunggu');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('dokumen_anak');
    }
};