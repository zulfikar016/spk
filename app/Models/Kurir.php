<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurirs';
    
    protected $fillable = [
        'kode_kurir', 'nama_kurir', 'jumlah_pengiriman',
        'otd', 'absensi', 'etika', 'status'
    ];

    protected $appends = ['skor_jumlah_pengiriman', 'skor_otd', 'skor_absensi', 'skor_etika'];

    public function nilaiKurirs()
    {
        return $this->hasMany(NilaiKurir::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }

    // Atribut untuk menghitung skor berdasarkan kriteria
    public function getSkorJumlahPengirimanAttribute()
    {
        $jumlah = $this->jumlah_pengiriman;
        
        if ($jumlah >= 2500) return 5;
        elseif ($jumlah >= 2000) return 4;
        elseif ($jumlah >= 1500) return 3;
        elseif ($jumlah >= 1000) return 2;
        else return 1;
    }

    public function getSkorOtdAttribute()
    {
        $otd = $this->otd;
        
        if ($otd >= 97) return 5;
        elseif ($otd >= 95) return 4;
        elseif ($otd >= 90) return 3;
        elseif ($otd >= 80) return 2;
        else return 1;
    }

    public function getSkorAbsensiAttribute()
    {
        $absensi = $this->absensi;
        
        if ($absensi == 100) return 5;
        elseif ($absensi >= 95) return 4;
        elseif ($absensi >= 85) return 3;
        elseif ($absensi >= 70) return 2;
        else return 1;
    }

    public function getSkorEtikaAttribute()
    {
        $etika = $this->etika * 20; // Konversi ke skala 0-100
        
        if ($etika >= 92) return 5;    // 4.6 * 20 = 92
        elseif ($etika >= 80) return 4; // 4.0 * 20 = 80
        elseif ($etika >= 60) return 3; // 3.0 * 20 = 60
        elseif ($etika >= 40) return 2; // 2.0 * 20 = 40
        else return 1;
    }
}
