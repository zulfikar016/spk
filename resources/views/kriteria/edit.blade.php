@extends('layouts.app')

@section('title', 'Edit Bobot Kriteria')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i> Edit Bobot Kriteria
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Kriteria</label>
                        <input type="text" class="form-control" value="{{ $kriteria->kode }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control" value="{{ $kriteria->nama_kriteria }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bobot" class="form-label">Bobot (%) *</label>
                        <input type="number" step="0.1" class="form-control @error('bobot') is-invalid @enderror" 
                               id="bobot" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required>
                        @error('bobot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan bobot dalam persentase (0-100)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jenis Kriteria</label>
                        <input type="text" class="form-control" value="{{ $kriteria->jenis }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" rows="3" readonly>{{ $kriteria->keterangan }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Bobot
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection