<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = 'ranking';
    
    protected $fillable = [
        'kurir_id',
        'total_nilai',
        'ranking',
        'status',
        'periode'
    ];

    // relasi ke tabel kurir
    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'kurir_id');
    }

    //  relasi detail penilaian
    public function details()
    {
        return $this->hasMany(NilaiKurir::class, 'kurir_id', 'kurir_id');
    }
}
