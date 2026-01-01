@extends('layouts.app')

@section('title', 'Data Kurir')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-users me-2"></i> Data Kurir
            </h5>
            <a href="{{ route('kurir.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Kurir
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Kurir</th>
                        <th>Nama Kurir</th>
                        <th>Pengiriman</th>
                        <th>OTD</th>
                        <th>Absensi</th>
                        <th>Etika</th>
                        <th>Status</th>
                        <th>Skor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kurirs as $kurir)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $kurir->kode_kurir }}</strong></td>
                        <td>{{ $kurir->nama_kurir }}</td>
                        <td>{{ number_format($kurir->jumlah_pengiriman) }}</td>
                        <td>{{ number_format($kurir->otd, 1) }}%</td>
                        <td>{{ number_format($kurir->absensi, 1) }}%</td>
                        <td>{{ number_format($kurir->etika, 1) }}</td>
                        <td>
                            <span class="badge bg-{{ $kurir->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ $kurir->status }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">C1: {{ $kurir->skor_jumlah_pengiriman }}</small><br>
                            <small class="text-muted">C2: {{ $kurir->skor_otd }}</small><br>
                            <small class="text-muted">C3: {{ $kurir->skor_absensi }}</small><br>
                            <small class="text-muted">C4: {{ $kurir->skor_etika }}</small>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('kurir.edit', $kurir->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#detailModal{{ $kurir->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form action="{{ route('kurir.destroy', $kurir->id) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Hapus data kurir ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Details -->
@foreach($kurirs as $kurir)
<div class="modal fade" id="detailModal{{ $kurir->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kurir: {{ $kurir->nama_kurir }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Personal</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Kode Kurir</th>
                                <td>{{ $kurir->kode_kurir }}</td>
                            </tr>
                            <tr>
                                <th>Nama Kurir</th>
                                <td>{{ $kurir->nama_kurir }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-{{ $kurir->status == 'aktif' ? 'success' : 'danger' }}">
                                        {{ $kurir->status }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Skor Konversi</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="60%">Jumlah Pengiriman</th>
                                <td><strong>{{ $kurir->skor_jumlah_pengiriman }}</strong></td>
                            </tr>
                            <tr>
                                <th>On-Time Delivery</th>
                                <td><strong>{{ $kurir->skor_otd }}</strong></td>
                            </tr>
                            <tr>
                                <th>Absensi</th>
                                <td><strong>{{ $kurir->skor_absensi }}</strong></td>
                            </tr>
                            <tr>
                                <th>Etika</th>
                                <td><strong>{{ $kurir->skor_etika }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6 class="mt-3">Detail Performa</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>{{ number_format($kurir->jumlah_pengiriman) }}</h5>
                                <small class="text-muted">Total Pengiriman</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>{{ number_format($kurir->otd, 1) }}%</h5>
                                <small class="text-muted">OTD Rate</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>{{ number_format($kurir->absensi, 1) }}%</h5>
                                <small class="text-muted">Absensi</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>{{ number_format($kurir->etika, 1) }}</h5>
                                <small class="text-muted">Nilai Etika</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection