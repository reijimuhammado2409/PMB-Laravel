<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = [
        'mahasiswa_id',
        'ukt_level_id',
        'biaya_pendaftaran',
        'total_pembayaran',
        'status',
        'bukti_transfer',
        'bukti_pendaftaran_pdf'
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke UKT Level
    public function uktLevel() {
        return $this->belongsTo(UktLevel::class, 'ukt_level_id');
    }
}
