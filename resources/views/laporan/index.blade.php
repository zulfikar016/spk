@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-pdf me-2"></i> Generate Laporan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan.generate.pdf') }}" method="POST" target="_blank">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="periode" class="form-label">Pilih Periode *</label>
                            <select class="form-select" id="periode" name="periode" required>
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periods as $period)
                                <option value="{{ $period->periode }}">
                                    {{ date('F Y', strtotime($period->periode . '-01')) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label">Tipe Laporan *</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="detail">Detail Lengkap</option>
                                <option value="summary">Ringkasan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i> Informasi Laporan</h6>
                        <ul class="mb-0">
                            <li><strong>Detail Lengkap:</strong> Menampilkan semua data kurir beserta perhitungan lengkap</li>
                            <li><strong>Ringkasan:</strong> Menampilkan summary dan kurir terbaik</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-download me-1"></i> Generate PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i> Periode Tersedia
                </h5>
            </div>
            <div class="card-body">
                @if($periods->isEmpty())
                    <div class="text-center py-3">
                        <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
                        <p class="mb-0">Belum ada data laporan</p>
                    </div>
                @else
                    <div class="list-group">
                        @foreach($periods as $period)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <strong>{{ date('F Y', strtotime($period->periode . '-01')) }}</strong>
                                </div>
                                <span class="badge bg-primary">
                                    {{ \App\Models\Ranking::where('periode', $period->periode)->count() }} kurir
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-print me-2"></i> Preview Laporan
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                    <p>Laporan akan dibuat dalam format PDF yang dapat diunduh.</p>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="card border">
                                <div class="card-body p-2">
                                    <small><i class="fas fa-file-alt text-primary"></i> Detail</small>
                                    <p class="mb-0 small text-muted">Halaman lengkap</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border">
                                <div class="card-body p-2">
                                    <small><i class="fas fa-chart-pie text-success"></i>Ringkasan</small>
                                    <p class="mb-0 small text-muted">1-2 halaman</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

