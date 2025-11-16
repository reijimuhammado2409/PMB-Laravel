<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama_id',
        'alamat_ktp',
        'alamat_sekarang',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'no_hp',
        'email',
        'status_menikah',
        'kewarganegaraan',
        'negara_asal',
        'foto',
        'status'
    ];

    // Relasi ke tabel User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Agama
    public function agama() {
        return $this->belongsTo(Agama::class);
    }

    // Relasi ke Provinsi, Kabupaten, Kecamatan
    public function provinsi() {
        return $this->belongsTo(Provinsi::class);
    }
    public function kabupaten() {
        return $this->belongsTo(Kabupaten::class);
    }
    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }

    
}

