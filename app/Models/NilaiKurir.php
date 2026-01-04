<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiKurir extends Model
{
    protected $table = 'nilai_kurirs';
    
    protected $fillable = [
        'kurir_id', 'kriteria_id', 'skor_awal',
        'skor_konversi', 'utility', 'nilai_akhir', 'periode'
    ];

    public function kurir()
    {
        return $this->belongsTo(Kurir::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}