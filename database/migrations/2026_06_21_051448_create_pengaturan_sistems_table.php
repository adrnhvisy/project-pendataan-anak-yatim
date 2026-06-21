<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengaturan_sistem', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Contoh: 'nama_aplikasi', 'logo_web', 'kontak_dinas'
            $table->text('value')->nullable(); // Contoh: 'Sistem Yatim Pangkalan Kerinci'
            $table->string('tipe')->default('text'); // 'text', 'image', 'boolean'
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pengaturan_sistem');
    }
};
