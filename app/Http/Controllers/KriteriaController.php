<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        $totalBobot = Kriteria::sum('bobot');
        return view('kriteria.index', compact('kriteria', 'totalBobot'));
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'bobot' => 'required|numeric|between:0,100',
        ]);

        // Validasi total bobot tidak melebihi 100%
        $totalBobot = Kriteria::sum('bobot') - $kriteria->bobot + $request->bobot;
        
        if ($totalBobot > 100) {
            return redirect()->back()
                ->with('error', 'Total bobot tidak boleh melebihi 100%. Total saat ini: ' . $totalBobot . '%');
        }

        $kriteria->update($request->only('bobot'));

        return redirect()->route('kriteria.index')
            ->with('success', 'Bobot kriteria berhasil diperbarui.');
    }
}