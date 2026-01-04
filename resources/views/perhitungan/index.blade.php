@extends('layouts.app')

@section('title', 'Perhitungan SMART')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-calculator me-2"></i> Perhitungan Metode SMART
            </h5>
            <form action="{{ route('perhitungan.hitung') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('Mulai perhitungan SMART?')">
                    <i class="fas fa-play me-1"></i> Jalankan Perhitungan
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <h6><i class="fas fa-info-circle me-2"></i> Informasi Perhitungan</h6>
            <p class="mb-0">
                Sistem akan menghitung nilai setiap kurir berdasarkan 4 kriteria dengan metode SMART.
                Hasil perhitungan akan digunakan untuk menentukan ranking kurir terbaik.
            </p>
        </div>
        
        <h5 class="mb-3">Data Kurir dan Skor</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="2">Kurir</th>
                        <th colspan="4" class="text-center">Nilai Asli</th>
                        <th colspan="4" class="text-center">Skor Konversi (1-5)</th>
                    </tr>
                    <tr>
                        <th>C1 (Paket)</th>
                        <th>C2 (OTD%)</th>
                        <th>C3 (Absensi%)</th>
                        <th>C4 (Etika)</th>
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>C4</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perhitungan as $data)
                    <tr>
                        <td>
                            <strong>{{ $data['kurir']->nama_kurir }}</strong><br>
                            <small class="text-muted">{{ $data['kurir']->kode_kurir }}</small>
                        </td>
                        <td>{{ number_format($data['kurir']->jumlah_pengiriman) }}</td>
                        <td>{{ number_format($data['kurir']->otd, 1) }}%</td>
                        <td>{{ number_format($data['kurir']->absensi, 1) }}%</td>
                        <td>{{ number_format($data['kurir']->etika, 1) }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $data['skor']['C1'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $data['skor']['C2'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning">{{ $data['skor']['C3'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $data['skor']['C4'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <h5 class="mt-4 mb-3">Detail Kriteria dan Bobot</h5>
        <div class="row">
            @foreach($kriteria as $k)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">{{ $k->kode }}: {{ $k->nama_kriteria }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary fs-6">{{ $k->bobot }}%</span>
                            <span class="badge bg-{{ $k->jenis == 'benefit' ? 'success' : 'danger' }}">
                                {{ $k->jenis }}
                            </span>
                        </div>
                        <small class="text-muted d-block mt-2">{{ $k->keterangan }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- <div class="alert alert-warning mt-4">
            <h6><i class="fas fa-lightbulb me-2"></i> Proses Perhitungan:</h6>
            <ol class="mb-0">
                <li>Konversi nilai asli ke skor 1-5 berdasarkan kriteria</li>
                <li>Hitung utility: Utility = (Skor / 5) × 100</li>
                <li>Hitung nilai akhir: Nilai = Utility × Bobot</li>
                <li>Jumlahkan nilai semua kriteria untuk setiap kurir</li>
                <li>Urutkan berdasarkan total nilai tertinggi</li>
                <li>Tentukan status: ⭐ Kurir Terbaik, Baik, atau Perlu Evaluasi</li>
            </ol>
        </div> --}}
    </div>
</div>
@endsection