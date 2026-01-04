@extends('layouts.app')

@section('title', 'Tambah Kurir')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i> Tambah Data Kurir Baru
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kurir.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_kurir" class="form-label">Kode Kurir *</label>
                            <input type="text" class="form-control @error('kode_kurir') is-invalid @enderror" 
                                   id="kode_kurir" name="kode_kurir" value="{{ old('kode_kurir') }}" required>
                            @error('kode_kurir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nama_kurir" class="form-label">Nama Kurir *</label>
                            <input type="text" class="form-control @error('nama_kurir') is-invalid @enderror" 
                                   id="nama_kurir" name="nama_kurir" value="{{ old('nama_kurir') }}" required>
                            @error('nama_kurir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_pengiriman" class="form-label">
                                Jumlah Pengiriman (paket) *
                            </label>
                            <input type="number" class="form-control @error('jumlah_pengiriman') is-invalid @enderror" 
                                   id="jumlah_pengiriman" name="jumlah_pengiriman" 
                                   value="{{ old('jumlah_pengiriman') }}" required min="0">
                            <small class="text-muted">
                                Skor 5 = ≥ 2500 paket, 4 = 2000-2500, 3 = 1500-1999, 2 = 1000-1499, 1 = < 1000
                            </small>
                            @error('jumlah_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="otd" class="form-label">
                                On-Time Delivery Rate (%) *
                            </label>
                            <input type="number" step="0.1" class="form-control @error('otd') is-invalid @enderror" 
                                   id="otd" name="otd" value="{{ old('otd') }}" required min="0" max="100">
                            <small class="text-muted">
                                Skor 5 = ≥ 97%, 4 = 95-97%, 3 = 90-94%, 2 = 80-89%, 1 = < 80%
                            </small>
                            @error('otd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="absensi" class="form-label">
                                Absensi/Kehadiran (%) *
                            </label>
                            <input type="number" step="0.1" class="form-control @error('absensi') is-invalid @enderror" 
                                   id="absensi" name="absensi" value="{{ old('absensi') }}" required min="0" max="100">
                            <small class="text-muted">
                                Skor 5 = 100%, 4 = 95-99%, 3 = 85-94%, 2 = 70-84%, 1 = < 70%
                            </small>
                            @error('absensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="etika" class="form-label">
                                Etika (Skala 0-5) *
                            </label>
                            <input type="number" step="0.1" class="form-control @error('etika') is-invalid @enderror" 
                                   id="etika" name="etika" value="{{ old('etika') }}" required min="0" max="5">
                            <small class="text-muted">
                                Skor 5 = 4.6-5.0, 4 = 4.0-4.5, 3 = 3.0-3.9, 2 = 2.0-2.9, 1 = < 2.0
                            </small>
                            @error('etika')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kurir.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection