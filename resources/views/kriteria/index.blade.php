@extends('layouts.app')

@section('title', 'Kriteria & Bobot')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list-check me-2"></i> Kriteria SMART
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Kriteria</th>
                                <th>Bobot</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriteria as $k)
                            <tr>
                                <td><strong>{{ $k->kode }}</strong></td>
                                <td>{{ $k->nama_kriteria }}</td>
                                <td>
                                    <span class="badge bg-primary fs-6">
                                        {{ number_format($k->bobot, 1) }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $k->jenis == 'benefit' ? 'success' : 'danger' }}">
                                        {{ $k->jenis }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $k->keterangan }}</small>
                                </td>
                                <td>
                                    @if(auth()->user()->role == 'admin')
                                    <a href="{{ route('kriteria.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit Bobot
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="alert alert-info mt-3">
                    <h6><i class="fas fa-info-circle me-2"></i> Total Bobot</h6>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" 
                             style="width: {{ $totalBobot }}%" aria-valuenow="{{ $totalBobot }}" 
                             aria-valuemin="0" aria-valuemax="100">
                            {{ number_format($totalBobot, 1) }}%
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        @if($totalBobot == 100)
                            <i class="fas fa-check-circle text-success"></i> Total bobot valid (100%)
                        @elseif($totalBobot < 100)
                            <i class="fas fa-exclamation-triangle text-warning"></i> 
                            Total bobot kurang dari 100% ({{ number_format(100 - $totalBobot, 1) }}%)
                        @else
                            <i class="fas fa-exclamation-circle text-danger"></i> 
                            Total bobot melebihi 100% ({{ number_format($totalBobot - 100, 1) }}%)
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        {{-- Keterangan metode SMART dihapus --}}
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i> Visualisasi Bobot
                </h5>
            </div>
            <div class="card-body">
                <canvas id="bobotChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Chart untuk visualisasi bobot
const bobotCtx = document.getElementById('bobotChart').getContext('2d');
new Chart(bobotCtx, {
    type: 'doughnut',
    data: {
        labels: @json($kriteria->pluck('nama_kriteria')->toArray()),
        datasets: [{
            data: @json($kriteria->pluck('bobot')->toArray()),
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