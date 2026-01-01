@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Kurir Aktif</h6>
                        <h2 class="mb-0">{{ $totalKurir }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    {{-- <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Kurir Terbaik</h6>
                        <h4 class="mb-0">{{ $kurirTerbaik->nama_kurir ?? '-' }}</h4>
                    </div>
                    <i class="fas fa-trophy fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div> --}}
    
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Rata-rata Performa</h6>
                        <h2 class="mb-0">{{ number_format($averagePerformance ?? 0, 2) }}</h2>
                    </div>
                    <i class="fas fa-chart-line fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Kriteria</h6>
                        <h2 class="mb-0">{{ $totalKriteria }}</h2>
                    </div>
                    <i class="fas fa-list-check fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i> Ranking 10 Besar Kurir
                </h5>
            </div>
            <div class="card-body">
                <canvas id="rankingChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i> Distribusi Bobot Kriteria
                </h5>
            </div>
            <div class="card-body">
                <canvas id="kriteriaChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i> Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('kurir.create') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-user-plus me-2"></i> Tambah Kurir
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('perhitungan.index') }}" class="btn btn-outline-success w-100 mb-2">
                            <i class="fas fa-calculator me-2"></i> Hitung SMART
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('ranking.index') }}" class="btn btn-outline-warning w-100 mb-2">
                            <i class="fas fa-trophy me-2"></i> Lihat Ranking
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('laporan.index') }}" class="btn btn-outline-info w-100 mb-2">
                            <i class="fas fa-file-pdf me-2"></i> Generate Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Data untuk chart ranking
const rankingLabels = @json($rankings->pluck('kurir.nama_kurir')->toArray());
const rankingData = @json($rankings->pluck('total_nilai')->toArray());

// Data untuk chart kriteria
const kriteriaLabels = @json($kriteria->pluck('nama_kriteria')->toArray());
const kriteriaData = @json($kriteria->pluck('bobot')->toArray());

// Ranking Chart
const rankingCtx = document.getElementById('rankingChart').getContext('2d');
new Chart(rankingCtx, {
    type: 'bar',
    data: {
        labels: rankingLabels,
        datasets: [{
            label: 'Nilai Akhir',
            data: rankingData,
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Nilai Akhir'
                }
            }
        }
    }
});

// Kriteria Chart
const kriteriaCtx = document.getElementById('kriteriaChart').getContext('2d');
new Chart(kriteriaCtx, {
    type: 'pie',
    data: {
        labels: kriteriaLabels,
        datasets: [{
            data: kriteriaData,
            backgroundColor: [
                '#1a237e',
                '#283593',
                '#303f9f',
                '#3949ab'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
@endsection