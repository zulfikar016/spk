<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        $latestPeriod = Ranking::max('periode');
        $rankings = Ranking::with('kurir')
            ->where('periode', $latestPeriod)
            ->orderBy('ranking')
            ->get();
            
        return view('ranking.index', compact('rankings', 'latestPeriod'));
    }
}