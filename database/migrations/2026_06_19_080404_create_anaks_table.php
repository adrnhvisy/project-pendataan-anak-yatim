<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi', 30)->unique();
            $table->string('nama_lengkap');
            $table->char('no_kk',16)->index();
            $table->char('nik', 16)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('status_anak', ['Yatim', 'Piatu', 'Yatim Piatu']);
            $table->string('no_rekening', 30)->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status_data', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending')->index();
            $table->foreignId('alamat_domisili_id')->constrained('alamat')->restrictOnDelete();
            // $table->foreignId('kelurahan_id')->constrained('kelurahan')->restrictOnDelete()->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('anak');
    }
};