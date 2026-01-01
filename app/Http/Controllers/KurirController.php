<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    public function index()
    {
        $kurirs = Kurir::all();
        return view('kurir.index', compact('kurirs'));
    }

    public function create()
    {
        return view('kurir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kurir' => 'required|unique:kurirs',
            'nama_kurir' => 'required',
            'jumlah_pengiriman' => 'required|integer|min:0',
            'otd' => 'required|numeric|between:0,100',
            'absensi' => 'required|numeric|between:0,100',
            'etika' => 'required|numeric|between:0,5',
        ]);

        Kurir::create($request->all());

        return redirect()->route('kurir.index')
            ->with('success', 'Data kurir berhasil ditambahkan.');
    }

    public function show(Kurir $kurir)
    {
        return view('kurir.show', compact('kurir'));
    }

    public function edit(Kurir $kurir)
    {
        return view('kurir.edit', compact('kurir'));
    }

    public function update(Request $request, Kurir $kurir)
    {
        $request->validate([
            'kode_kurir' => 'required|unique:kurirs,kode_kurir,' . $kurir->id,
            'nama_kurir' => 'required',
            'jumlah_pengiriman' => 'required|integer|min:0',
            'otd' => 'required|numeric|between:0,100',
            'absensi' => 'required|numeric|between:0,100',
            'etika' => 'required|numeric|between:0,5',
        ]);

        $kurir->update($request->all());

        return redirect()->route('kurir.index')
            ->with('success', 'Data kurir berhasil diperbarui.');
    }

    public function destroy(Kurir $kurir)
    {
        $kurir->delete();
        return redirect()->route('kurir.index')
            ->with('success', 'Data kurir berhasil dihapus.');
    }
}