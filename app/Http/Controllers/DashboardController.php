<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Ranking;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKurir = Kurir::where('status', 'aktif')->count();
        $totalKriteria = Kriteria::count();
        
        // Ambil ranking terbaru
        $latestRanking = Ranking::latest('periode')->first();
        $kurirTerbaik = $latestRanking ? $latestRanking->kurir : null;
        
        // Rata-rata performa
        $averagePerformance = Ranking::where('periode', $latestRanking->periode ?? now())
            ->avg('total_nilai');
            
        // Data untuk chart ranking
        $rankings = Ranking::with('kurir')
            ->where('periode', $latestRanking->periode ?? now())
            ->orderBy('ranking')
            ->limit(10)
            ->get();
            
        // Data untuk chart kriteria
        $kriteria = Kriteria::all();
        
        return view('dashboard.index', compact(
            'totalKurir',
            'kurirTerbaik',
            'averagePerformance',
            'rankings',
            'kriteria',
            'totalKriteria'
        ));
    }
}