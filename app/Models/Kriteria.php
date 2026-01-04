<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    
    protected $fillable = [
        'kode', 'nama_kriteria', 'bobot', 'jenis', 'keterangan'
    ];

    public function nilaiKurirs()
    {
        return $this->hasMany(NilaiKurir::class);
    }
}