@extends('layouts.app')

@section('title', 'Ranking Kurir')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-trophy me-2"></i> Ranking Kurir Terbaik
            </h5>
            <div>
                <span class="badge bg-primary">
                    <i class="fas fa-calendar me-1"></i> Periode: {{ $latestPeriod ?? date('F Y') }}
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($rankings->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
            <h5>Belum ada data ranking</h5>
            <p>Silakan jalankan perhitungan SMART terlebih dahulu.</p>
            <a href="{{ route('perhitungan.index') }}" class="btn btn-primary">
                <i class="fas fa-calculator me-1"></i> Ke Halaman Perhitungan
            </a>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Kurir</th>
                        <th>Kode</th>
                        <th>Total Nilai</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rankings as $ranking)
                    <tr>
                        <td width="80">
                            @if($ranking->ranking == 1)
                                <div class="text-center">
                                    <span class="badge bg-warning fs-6 p-2">
                                        <i class="fas fa-crown"></i> #{{ $ranking->ranking }}
                                    </span>
                                </div>
                            @elseif($ranking->ranking <= 3)
                                <div class="text-center">
                                    <span class="badge bg-success fs-6 p-2">
                                        #{{ $ranking->ranking }}
                                    </span>
                                </div>
                            @elseif($ranking->ranking <= 10)
                                <div class="text-center">
                                    <span class="badge bg-primary fs-6 p-2">
                                        #{{ $ranking->ranking }}
                                    </span>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="badge bg-secondary fs-6 p-2">
                                        #{{ $ranking->ranking }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $ranking->kurir->nama_kurir }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-dark">{{ $ranking->kurir->kode_kurir }}</span>
                        </td>
                        <td>
                            <h5 class="mb-0">{{ number_format($ranking->total_nilai, 4) }}</h5>
                        </td>
                        <td>
                            @if($ranking->status == '⭐ Kurir Terbaik')
                                <span class="badge bg-warning fs-6 p-2">
                                    <i class="fas fa-star"></i> Kurir Terbaik
                                </span>
                            @elseif($ranking->status == 'Baik')
                                <span class="badge bg-success fs-6 p-2">
                                    <i class="fas fa-check-circle"></i> Baik
                                </span>
                            @else
                                <span class="badge bg-danger fs-6 p-2">
                                    <i class="fas fa-exclamation-triangle"></i> Perlu Evaluasi
                                </span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                    data-bs-target="#detailModal{{ $ranking->id }}">
                                <i class="fas fa-chart-bar"></i> Detail Nilai
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Visualisasi Ranking</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="rankingChart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Distribusi Status</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail -->
@foreach($rankings as $ranking)
<div class="modal fade" id="detailModal{{ $ranking->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Nilai: {{ $ranking->kurir->nama_kurir }} (Ranking #{{ $ranking->ranking }})
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Kode Kurir</th>
                                <td>{{ $ranking->kurir->kode_kurir }}</td>
                            </tr>
                            <tr>
                                <th>Nama Kurir</th>
                                <td>{{ $ranking->kurir->nama_kurir }}</td>
                            </tr>
                            <tr>
                                <th>Total Nilai</th>
                                <td><strong>{{ number_format($ranking->total_nilai, 4) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Ranking</th>
                                <td><strong>#{{ $ranking->ranking }}</strong></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($ranking->status == '⭐ Kurir Terbaik')
                                        <span class="badge bg-warning">⭐ Kurir Terbaik</span>
                                    @elseif($ranking->status == 'Baik')
                                        <span class="badge bg-success">Baik</span>
                                    @else
                                        <span class="badge bg-danger">Perlu Evaluasi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td>{{ $ranking->periode }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6>Detail Perhitungan per Kriteria</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th>Kriteria</th>
                                <th>Nilai Asli</th>
                                <th>Skor (1-5)</th>
                                <th>Utility</th>
                                <th>Bobot</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nilaiKurirs = $ranking->kurir->nilaiKurirs()
                                    ->where('periode', $ranking->periode)
                                    ->with('kriteria')
                                    ->get();
                            @endphp
                            @foreach($nilaiKurirs as $nilai)
                            <tr>
                                <td>{{ $nilai->kriteria->nama_kriteria }}</td>
                                <td>{{ number_format($nilai->skor_awal, 2) }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $nilai->skor_konversi }}</span>
                                </td>
                                <td>{{ number_format($nilai->utility, 2) }}</td>
                                <td>{{ number_format($nilai->kriteria->bobot, 1) }}%</td>
                                <td><strong>{{ number_format($nilai->nilai_akhir, 4) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td colspan="5" class="text-end"><strong>Total</strong></td>
                                <td><strong>{{ number_format($ranking->total_nilai, 4) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
@if(!$rankings->isEmpty())
<script>
// Data untuk chart ranking
const rankingLabels = @json($rankings->pluck('kurir.nama_kurir')->take(10)->toArray());
const rankingValues = @json($rankings->pluck('total_nilai')->take(10)->toArray());
const rankingColors = @json($rankings->map(function($r) {
    if($r->ranking == 1) return '#ffc107';
    if($r->ranking <= 3) return '#28a745';
    if($r->ranking <= 10) return '#007bff';
    return '#6c757d';
})->take(10)->toArray());

// Data untuk chart status
const statusCounts = {
    'terbaik': @json($rankings->where('status', '⭐ Kurir Terbaik')->count()),
    'baik': @json($rankings->where('status', 'Baik')->count()),
    'evaluasi': @json($rankings->where('status', 'Perlu Evaluasi')->count())
};

// Ranking Chart
const rankingCtx = document.getElementById('rankingChart').getContext('2d');
new Chart(rankingCtx, {
    type: 'bar',
    data: {
        labels: rankingLabels,
        datasets: [{
            label: 'Nilai Akhir',
            data: rankingValues,
            backgroundColor: rankingColors,
            borderColor: rankingColors.map(c => c.replace('0.8', '1')),
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
            },
            x: {
                ticks: {
                    maxRotation: 45,
                    minRotation: 45
                }
            }
        }
    }
});

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['⭐ Kurir Terbaik', 'Baik', 'Perlu Evaluasi'],
        datasets: [{
            data: [statusCounts.terbaik, statusCounts.baik, statusCounts.evaluasi],
            backgroundColor: ['#ffc107', '#28a745', '#dc3545']
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
@endif
@endpush
@endsection