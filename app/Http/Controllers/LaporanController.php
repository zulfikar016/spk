<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\Kurir;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $periods = Ranking::select('periode')
            ->distinct()
            ->orderBy('periode', 'desc')
            ->get();
            
        return view('laporan.index', compact('periods'));
    }

    public function generatePDF(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'type' => 'required|in:detail,summary'
        ]);

        $periode = $request->periode;
        
        if ($request->type == 'detail') {
            $rankings = Ranking::with('kurir')
                ->where('periode', $periode)
                ->orderBy('ranking')
                ->get();
                
            $pdf = Pdf::loadView('laporan.pdf.detail', compact('rankings', 'periode'));
            return $pdf->download('laporan-kurir-' . $periode . '.pdf');
        } else {
            $summary = [
                'total_kurir' => Ranking::where('periode', $periode)->count(),
                'kurir_terbaik' => Ranking::with('kurir')
                    ->where('periode', $periode)
                    ->where('ranking', 1)
                    ->first(),
                'rata_rata' => Ranking::where('periode', $periode)->avg('total_nilai'),
            ];
            
            $pdf = Pdf::loadView('laporan.pdf.summary', compact('summary', 'periode'));
            return $pdf->download('summary-kurir-' . $periode . '.pdf');
        }
    }
}