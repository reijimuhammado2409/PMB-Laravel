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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->foreignId('agama_id')->constrained('agama')->onDelete('restrict');
            $table->text('alamat_ktp');
            $table->text('alamat_sekarang');
            $table->foreignId('provinsi_id')->constrained('provinsi')->onDelete('restrict');
            $table->foreignId('kabupaten_id')->constrained('kabupaten')->onDelete('restrict');
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->onDelete('restrict');
            $table->string('no_hp');
            $table->string('email');
            $table->enum('status_menikah', ['Belum_Menikah', 'Menikah', 'Duda', 'Janda']);
            $table->enum('kewarganegaraan', ['WNI_Asli', 'WNI_Keturunan', 'WNA'])->default('WNI_Asli');
            $table->string('negara_asal')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
