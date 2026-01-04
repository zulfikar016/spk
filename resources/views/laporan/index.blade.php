@extends('layouts.app')

@section('title', 'Laporan Penilaian Kurir')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i> Laporan Penilaian Kurir
                </h5>
            </div>
        </div>

        <div class="card-body">

            {{-- FILTER PERIODE --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Periode</label>
                    <select class="form-select" onchange="filterByPeriod(this.value)">
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periods as $p)
                            <option value="{{ $p->periode }}"
                                {{ $selectedPeriod == $p->periode ? 'selected' : '' }}>
                                {{ date('F Y', strtotime($p->periode.'-01')) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- KONDISI --}}
            @if(!$selectedPeriod)
                <div class="text-center py-5 text-muted">
                    <p>Silakan pilih periode untuk melihat laporan</p>
                </div>
            @elseif($rankings->isEmpty())
                <div class="text-center py-5 text-muted">
                    <p>Tidak ada data pada periode ini</p>
                </div>
            @else

            {{-- TABEL RANKING --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th class="text-start">Kurir</th>
                            <th>Total Nilai</th>
                            <th>Ranking</th>
                            {{-- <th>Status</th> --}}
                            <th width="90">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rankings as $ranking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="text-start">
                                <strong>{{ $ranking->kurir->nama_kurir }}</strong><br>
                                <small class="text-muted">{{ $ranking->kurir->kode_kurir }}</small>
                            </td>

                            <td class="fw-bold">
                                {{ number_format($ranking->total_nilai, 4) }}
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    #{{ $ranking->ranking }}
                                </span>
                            </td>

                            {{-- <td>
                                <span class="badge bg-success">
                                    {{ $ranking->status }}
                                </span>
                            </td> --}}

                            <td>
                                <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal-{{ $ranking->id }}">
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
</div>

{{-- MODAL DETAIL --}}
@foreach($rankings as $ranking)
<div class="modal fade" id="detailModal-{{ $ranking->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    Detail Penilaian – {{ $ranking->kurir->nama_kurir }}
                </h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>Kriteria</th>
                            <th>Nilai Asli</th>
                            <th>Skor Konversi</th>
                            <th>Utility (%)</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ranking->details as $d)
                        <tr>
                            <td>{{ $d->kriteria->nama_kriteria }}</td>
                            <td>{{ $d->skor_awal }}</td>
                            <td>{{ $d->skor_konversi }}</td>
                            <td>{{ number_format($d->utility, 2) }}</td>
                            <td class="fw-bold">
                                {{ number_format($d->nilai_akhir, 4) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <th colspan="4" class="text-end">Total Nilai</th>
                            <th>{{ number_format($ranking->total_nilai, 4) }}</th>
                        </tr>
                    </tfoot>
                </table>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
function filterByPeriod(val){
    if(val){
        window.location.href = "{{ route('laporan.index') }}?periode=" + val;
    }
}
</script>
@endpush
@endsection
