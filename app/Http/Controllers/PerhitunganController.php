<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Kriteria;
use App\Models\NilaiKurir;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function index()
    {
        $kurirs = Kurir::where('status', 'aktif')->get();
        $kriteria = Kriteria::all();
        
        // Hitung skor untuk setiap kurir
        $perhitungan = [];
        foreach ($kurirs as $kurir) {
            $skor = [
                'C1' => $kurir->skor_jumlah_pengiriman,
                'C2' => $kurir->skor_otd,
                'C3' => $kurir->skor_absensi,
                'C4' => $kurir->skor_etika,
            ];
            
            $perhitungan[$kurir->id] = [
                'kurir' => $kurir,
                'skor' => $skor
            ];
        }
        
        return view('perhitungan.index', compact('kurirs', 'kriteria', 'perhitungan'));
    }

    public function hitungSmart()
    {
        DB::beginTransaction();
        
        try {
            $kurirs = Kurir::where('status', 'aktif')->get();
            $kriteria = Kriteria::all();
           $periode = now()->startOfMonth()->toDateString();
            
            // Hapus data lama untuk periode yang sama
            NilaiKurir::where('periode', $periode)->delete();
            Ranking::where('periode', $periode)->delete();
            
            $hasilPerhitungan = [];
            
            foreach ($kurirs as $kurir) {
                $totalNilai = 0;
                
                foreach ($kriteria as $k) {
                    // Get skor berdasarkan kriteria
                    $skor = 0;
                    switch ($k->kode) {
                        case 'C1':
                            $skor = $kurir->skor_jumlah_pengiriman;
                            break;
                        case 'C2':
                            $skor = $kurir->skor_otd;
                            break;
                        case 'C3':
                            $skor = $kurir->skor_absensi;
                            break;
                        case 'C4':
                            $skor = $kurir->skor_etika;
                            break;
                    }
                    
                    // Hitung utility (karena semua benefit, utility = skor/max_skor * 100)
                    $utility = ($skor / 5) * 100;
                    
                    // Hitung nilai akhir (utility * bobot)
                    $nilaiAkhir = ($utility / 100) * $k->bobot;
                    
                    // Simpan ke database
                    NilaiKurir::create([
                        'kurir_id' => $kurir->id,
                        'kriteria_id' => $k->id,
                        'skor_awal' => $this->getNilaiAsli($k->kode, $kurir),
                        'skor_konversi' => $skor,
                        'utility' => $utility,
                        'nilai_akhir' => $nilaiAkhir,
                        'periode' => $periode
                    ]);
                    
                    $totalNilai += $nilaiAkhir;
                }
                
                // Simpan total nilai untuk ranking
                $hasilPerhitungan[$kurir->id] = $totalNilai;
            }
            
            // Buat ranking
            arsort($hasilPerhitungan);
            $ranking = 1;
            
            foreach ($hasilPerhitungan as $kurirId => $totalNilai) {
                // Tentukan status berdasarkan ranking
                $status = 'Perlu Evaluasi';
                if ($ranking == 1) {
                    $status = '⭐ Kurir Terbaik';
                } elseif ($ranking <= ceil(count($hasilPerhitungan) * 0.3)) { // Top 30%
                    $status = 'Baik';
                }
                
                Ranking::create([
                    'kurir_id' => $kurirId,
                    'total_nilai' => $totalNilai,
                    'ranking' => $ranking,
                    'status' => $status,
                    'periode' => $periode
                ]);
                
                $ranking++;
            }
            
            DB::commit();
            
            return redirect()->route('ranking.index')
                ->with('success', 'Perhitungan SMART berhasil dilakukan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    private function getNilaiAsli($kodeKriteria, $kurir)
    {
        switch ($kodeKriteria) {
            case 'C1':
                return $kurir->jumlah_pengiriman;
            case 'C2':
                return $kurir->otd;
            case 'C3':
                return $kurir->absensi;
            case 'C4':
                return $kurir->etika;
            default:
                return 0;
        }
    }
}