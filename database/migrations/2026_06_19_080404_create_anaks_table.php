<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->string('nama_lengkap');
            $table->string('no_kk');
            $table->char('nik', 16)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('status_anak', ['Yatim', 'Piatu', 'Yatim Piatu']);
            $table->string('no_rekening')->nullable();
            $table->enum('status_data', ['Draft', 'Pending', 'Disetujui', 'Ditolak'])->default('Draft');
            $table->foreignId('alamat_domisili_id')->constrained('alamat')->restrictOnDelete();
            $table->foreignId('kelurahan_id')->constrained('kelurahan')->restrictOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('anak');
    }
};