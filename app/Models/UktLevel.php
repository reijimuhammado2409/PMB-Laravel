<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UktLevel extends Model
{
    protected $table = 'ukt_level';
    protected $fillable = ['level', 'deskripsi', 'penghasilan_min', 'penghasilan_max', 'nominal'];

    public function pembayaran() {
        return $this->hasMany(Pembayaran::class);
    }
}
