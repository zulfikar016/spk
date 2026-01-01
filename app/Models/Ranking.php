<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = 'ranking';
    
    protected $fillable = [
        'kurir_id', 'total_nilai', 'ranking',
        'status', 'periode'
    ];

    public function kurir()
    {
        return $this->belongsTo(Kurir::class);
    }
}