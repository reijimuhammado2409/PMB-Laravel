<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
    protected $fillable = ['nama'];

    public function kabupaten() {
        return $this->hasMany(Kabupaten::class);
    }
}
