@extends('layouts.app')

@section('title', 'Ranking Kurir')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-trophy me-2"></i> Ranking Kurir Terbaik
            </h5>
            <span class="badge bg-primary">
                <i class="fas fa-calendar me-1"></i>
                Periode: {{ $latestPeriod ?? date('F Y') }}
            </span>
        </div>
    </div>

    <div class="card-body">
        @if($rankings->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                <p>Belum ada data ranking</p>
                <a href="{{ route('perhitungan.index') }}" class="btn btn-primary">
                    <i class="fas fa-calculator me-1"></i> Hitung SMART
                </a>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="90">Ranking</th>
                        <th class="text-start">Kurir</th>
                        <th>Kode</th>
                        <th>Total Nilai</th>
                        <th width="120">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rankings as $ranking)
                    <tr>
                        <td class="text-center">
                            @if($ranking->ranking == 1)
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-crown"></i> #1
                                </span>
                            @elseif($ranking->ranking <= 3)
                                <span class="badge bg-success fs-6">#{{ $ranking->ranking }}</span>
                            @else
                                <span class="badge bg-secondary fs-6">#{{ $ranking->ranking }}</span>
                            @endif
                        </td>

                        <td class="text-start">
                            <strong>{{ $ranking->kurir->nama_kurir }}</strong>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-dark">
                                {{ $ranking->kurir->kode_kurir }}
                            </span>
                        </td>

                        <td class="text-center fw-bold">
                            {{ number_format($ranking->total_nilai, 4) }}
                        </td>

                        <td class="text-center">
                            <button class="btn btn-sm btn-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $ranking->id }}">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- MODAL DETAIL --}}
@foreach($rankings as $ranking)
<div class="modal fade" id="detailModal{{ $ranking->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Nilai — {{ $ranking->kurir->nama_kurir }}
                    (Ranking #{{ $ranking->ranking }})
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th>Kode Kurir</th>
                                <td>{{ $ranking->kurir->kode_kurir }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $ranking->kurir->nama_kurir }}</td>
                            </tr>
                            <tr>
                                <th>Ranking</th>
                                <td>#{{ $ranking->ranking }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th>Total Nilai</th>
                                <td><strong>{{ number_format($ranking->total_nilai, 4) }}</strong></td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td>{{ $ranking->periode }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h6>Detail Perhitungan SMART</h6>

                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <th>Nilai Asli</th>
                                <th>Skor (1–5)</th>
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

                                {{-- NILAI ASLI TANPA .00 --}}
                                <td>{{ $nilai->skor_awal }}</td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $nilai->skor_konversi }}
                                    </span>
                                </td>

                                <td>{{ number_format($nilai->utility, 2) }}</td>
                                <td>{{ $nilai->kriteria->bobot }}%</td>
                                <td><strong>{{ number_format($nilai->nilai_akhir, 4) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-dark">
                            <tr>
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
@endsection
