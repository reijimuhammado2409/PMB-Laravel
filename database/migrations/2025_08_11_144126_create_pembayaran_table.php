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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('ukt_level_id')->constrained('ukt_level')->onDelete('restrict');
            $table->integer('biaya_pendaftaran');
            $table->integer('total_pembayaran');
            $table->enum('status', ['Belum_Bayar', 'Sudah_Bayar', 'Pending'])->default('Belum_Bayar');
            $table->string('bukti_transfer')->nullable();
            $table->string('bukti_pendaftaran_pdf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
