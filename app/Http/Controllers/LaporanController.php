<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\Kriteria;
use App\Models\Kurir;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua periode yang tersedia
        $periods = Ranking::select('periode')
            ->distinct()
            ->orderBy('periode', 'desc')
            ->get();
        
        // Ambil periode yang dipilih dari request atau gunakan yang pertama
        $selectedPeriod = $request->get('periode', $periods->first()->periode ?? null);
        
        // Ambil data ranking berdasarkan periode yang dipilih
        $rankings = collect(); // Initialize as empty collection
        
        if ($selectedPeriod) {
            $rankings = Ranking::with(['kurir', 'details.kriteria'])
                ->where('periode', $selectedPeriod)
                ->orderBy('ranking') // Perhatikan: field mungkin 'ranking' bukan 'peringkat'
                ->get();
        }
        
        return view('laporan.index', compact('periods', 'selectedPeriod', 'rankings'));
    }

    public function generatePDF(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'type' => 'required|in:detail,summary',
            'kurir_ids' => 'array'
        ]);

        $periode = $request->periode;
        $type = $request->type;
        $kurirIds = $request->kurir_ids ?? [];
        
        // Ambil data berdasarkan filter
        $query = Ranking::with(['kurir', 'details.kriteria'])
            ->where('periode', $periode);
            
        if (!empty($kurirIds)) {
            $query->whereIn('kurir_id', $kurirIds);
        }
        
        $rankings = $query->orderBy('ranking')->get();
        $kriteria = Kriteria::all();
        
        // Validasi jika tidak ada data
        if ($rankings->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk periode yang dipilih.');
        }
        
        // Generate PDF berdasarkan tipe
        if ($type == 'detail') {
            $pdf = Pdf::loadView('laporan.pdf.detail', compact('rankings', 'kriteria', 'periode'));
            $filename = 'Laporan_Detail_Kurir_' . date('F_Y', strtotime($periode . '-01')) . '.pdf';
        } else {
            // Hitung summary
            $summary = [
                'total_kurir' => $rankings->count(),
                'kurir_terbaik' => $rankings->where('ranking', 1)->first(),
                'rata_rata' => $rankings->avg('total_nilai') ?? $rankings->avg('nilai_akhir') ?? 0,
                'nilai_tertinggi' => $rankings->max('total_nilai') ?? $rankings->max('nilai_akhir') ?? 0,
                'nilai_terendah' => $rankings->min('total_nilai') ?? $rankings->min('nilai_akhir') ?? 0,
                'periode' => $periode,
                'rankings' => $rankings->take(10) // Ambil 10 terbaik untuk summary
            ];
            
            $pdf = Pdf::loadView('laporan.pdf.summary', compact('summary', 'periode'));
            $filename = 'Laporan_Summary_Kurir_' . date('F_Y', strtotime($periode . '-01')) . '.pdf';
        }
        
        // Set paper size dan orientation
        $pdf->setPaper('A4', $type == 'detail' ? 'portrait' : 'landscape');
        
        return $pdf->download($filename);
    }
    
    /**
     * Get statistics for dashboard or other purposes
     */
    public function getStatistics(Request $request)
    {
        $periode = $request->get('periode', date('Y-m'));
        
        $rankings = Ranking::with('kurir')
            ->where('periode', $periode)
            ->orderBy('ranking')
            ->get();
            
        if ($rankings->isEmpty()) {
            return response()->json(['error' => 'No data found'], 404);
        }
        
        $statistics = [
            'total_kurir' => $rankings->count(),
            'nilai_tertinggi' => $rankings->max('total_nilai') ?? $rankings->max('nilai_akhir') ?? 0,
            'nilai_terendah' => $rankings->min('total_nilai') ?? $rankings->min('nilai_akhir') ?? 0,
            'rata_rata' => $rankings->avg('total_nilai') ?? $rankings->avg('nilai_akhir') ?? 0,
            'periode' => $periode,
            'top_3' => $rankings->take(3)->map(function($ranking) {
                return [
                    'nama' => $ranking->kurir->nama_kurir ?? 'N/A',
                    'nilai' => $ranking->total_nilai ?? $ranking->nilai_akhir ?? 0,
                    'ranking' => $ranking->ranking
                ];
            })
        ];
        
        return response()->json($statistics);
    }
    
    /**
     * API untuk mendapatkan data ranking berdasarkan periode
     */
    public function getRankingsByPeriod($periode)
    {
        $rankings = Ranking::with(['kurir', 'details.kriteria'])
            ->where('periode', $periode)
            ->orderBy('ranking')
            ->get()
            ->map(function($ranking) {
                return [
                    'id' => $ranking->id,
                    'kode_kurir' => $ranking->kurir->kode_kurir ?? 'N/A',
                    'nama_kurir' => $ranking->kurir->nama_kurir ?? 'N/A',
                    'nilai_akhir' => $ranking->total_nilai ?? $ranking->nilai_akhir ?? 0,
                    'ranking' => $ranking->ranking,
                    'details' => $ranking->details->map(function($detail) {
                        return [
                            'kriteria' => $detail->kriteria->nama_kriteria ?? 'N/A',
                            'nilai_normalisasi' => $detail->nilai_normalisasi ?? 0,
                            'nilai_terbobot' => $detail->nilai_terbobot ?? 0
                        ];
                    })
                ];
            });
            
        return response()->json($rankings);
    }
}