<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Periode extends Model
{
    protected $table = 'periodes';
    
    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'is_active',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean'
    ];

    // Relasi ke kurir
    public function kurirs()
    {
        return $this->hasMany(Kurir::class, 'periode_id');
    }

    // Relasi ke nilai kurir
    public function nilaiKurirs()
    {
        return $this->hasMany(NilaiKurir::class, 'periode_id');
    }

    // Relasi ke ranking
    public function rankings()
    {
        return $this->hasMany(Ranking::class, 'periode_id');
    }

    // Scope untuk mendapatkan periode aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk mengaktifkan periode ini dan menonaktifkan yang lain
    public function activate()
    {
        // Nonaktifkan semua periode
        self::query()->update(['is_active' => false]);
        
        // Aktifkan periode ini
        $this->is_active = true;
        $this->save();
        
        return $this;
    }

    // Method untuk mendapatkan periode aktif
    public static function getActivePeriode()
    {
        return self::where('is_active', true)->first();
    }

    // Method untuk copy data dari periode sebelumnya (opsional)
    public function copyFromPreviousPeriode($previousPeriodeId = null)
    {
        if (!$previousPeriodeId) {
            $previousPeriode = self::where('id', '!=', $this->id)
                ->orderBy('tanggal_mulai', 'desc')
                ->first();
        } else {
            $previousPeriode = self::find($previousPeriodeId);
        }

        if (!$previousPeriode) {
            return false;
        }

        // Copy data kurir dari periode sebelumnya
        $oldKurirs = Kurir::where('periode_id', $previousPeriode->id)->get();
        
        foreach ($oldKurirs as $oldKurir) {
            $newKurir = $oldKurir->replicate();
            $newKurir->periode_id = $this->id;
            // Reset data pengiriman untuk periode baru
            $newKurir->jumlah_pengiriman = 0;
            $newKurir->otd = 0;
            $newKurir->absensi = 0;
            $newKurir->etika = 0;
            $newKurir->save();
        }

        return true;
    }
}