<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Kurir;
use App\Models\NilaiKurir;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    // Menampilkan daftar periode
    public function index()
    {
        $periodes = Periode::orderBy('tanggal_mulai', 'desc')->get();
        $activePeriode = Periode::getActivePeriode();
        
        return view('periode.index', compact('periodes', 'activePeriode'));
    }

    // Form tambah periode baru
    public function create()
    {
        // Ambil periode terakhir untuk referensi
        $lastPeriode = Periode::withCount('kurirs')->latest()->first();
        
        return view('periode.create', compact('lastPeriode'));
    }

    // Simpan periode baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|unique:periodes',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'keterangan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $periode = Periode::create([
                'nama_periode' => $request->nama_periode,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keterangan' => $request->keterangan,
                'is_active' => false,
                'status' => 'draft'
            ]);

            // Jika diminta, copy data kurir dari periode sebelumnya
            if ($request->has('copy_from_previous') && $request->copy_from_previous) {
                $periode->copyFromPreviousPeriode();
            }

            DB::commit();
            return redirect()->route('periode.index')
                           ->with('success', 'Periode berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Gagal menambahkan periode: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // Aktifkan periode tertentu
    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $periode = Periode::findOrFail($id);
            
            // Nonaktifkan semua periode
            Periode::query()->update(['is_active' => false]);
            
            // Aktifkan periode yang dipilih
            $periode->is_active = true;
            $periode->status = 'aktif';
            $periode->save();

            DB::commit();
            return redirect()->route('periode.index')
                           ->with('success', 'Periode ' . $periode->nama_periode . ' berhasil diaktifkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Gagal mengaktifkan periode: ' . $e->getMessage());
        }
    }

    // Lihat detail periode dengan data kurir, nilai, dan ranking
    public function show($id)
    {
        $periode = Periode::with(['kurirs', 'rankings.kurir'])->findOrFail($id);
        
        $kurirs = Kurir::where('periode_id', $id)->get();
        $rankings = Ranking::where('periode_id', $id)
                          ->orderBy('ranking', 'asc')
                          ->with('kurir')
                          ->get();
        
        return view('periode.show', compact('periode', 'kurirs', 'rankings'));
    }

    // Selesaikan periode
    public function complete($id)
    {
        DB::beginTransaction();
        try {
            $periode = Periode::findOrFail($id);
            $periode->status = 'selesai';
            $periode->is_active = false;
            $periode->save();

            DB::commit();
            return redirect()->route('periode.index')
                           ->with('success', 'Periode berhasil diselesaikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Gagal menyelesaikan periode: ' . $e->getMessage());
        }
    }

    // Hapus periode
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $periode = Periode::findOrFail($id);
            
            // Cek apakah periode sedang aktif
            if ($periode->is_active) {
                return redirect()->back()
                               ->with('error', 'Tidak dapat menghapus periode yang sedang aktif');
            }

            $periode->delete();

            DB::commit();
            return redirect()->route('periode.index')
                           ->with('success', 'Periode berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Gagal menghapus periode: ' . $e->getMessage());
        }
    }

    // Reset data periode (untuk periode aktif)
    public function resetData($id)
    {
        DB::beginTransaction();
        try {
            $periode = Periode::findOrFail($id);

            // Hapus semua data kurir, nilai, dan ranking untuk periode ini
            NilaiKurir::where('periode_id', $id)->delete();
            Ranking::where('periode_id', $id)->delete();
            Kurir::where('periode_id', $id)->delete();

            DB::commit();
            return redirect()->route('periode.show', $id)
                           ->with('success', 'Data periode berhasil direset');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Gagal mereset data periode: ' . $e->getMessage());
        }
    }
}