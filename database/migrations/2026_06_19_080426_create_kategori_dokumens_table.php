<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kategori_dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->boolean('is_wajib')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('kategori_dokumen');
    }
};