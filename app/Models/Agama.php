<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agama';
    protected $fillable = ['nama'];

    public function mahasiswa() {
        return $this->hasMany(Mahasiswa::class);
    }
}
