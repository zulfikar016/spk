@extends('layouts.app')

@section('title', 'Edit Kurir')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i> Edit Data Kurir
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('kurir.update', $kurir->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Kurir *</label>
                            <input type="text"
                                   name="kode_kurir"
                                   class="form-control @error('kode_kurir') is-invalid @enderror"
                                   value="{{ old('kode_kurir', $kurir->kode_kurir) }}"
                                   required>
                            @error('kode_kurir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Kurir *</label>
                            <input type="text"
                                   name="nama_kurir"
                                   class="form-control @error('nama_kurir') is-invalid @enderror"
                                   value="{{ old('nama_kurir', $kurir->nama_kurir) }}"
                                   required>
                            @error('nama_kurir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Pengiriman *</label>
                            <input type="number"
                                   name="jumlah_pengiriman"
                                   class="form-control @error('jumlah_pengiriman') is-invalid @enderror"
                                   value="{{ old('jumlah_pengiriman', $kurir->jumlah_pengiriman) }}"
                                   min="0" required>
                            @error('jumlah_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">OTD (%) *</label>
                            <input type="number" step="0.1"
                                   name="otd"
                                   class="form-control @error('otd') is-invalid @enderror"
                                   value="{{ old('otd', $kurir->otd) }}"
                                   min="0" max="100" required>
                            @error('otd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Absensi (%) *</label>
                            <input type="number" step="0.1"
                                   name="absensi"
                                   class="form-control @error('absensi') is-invalid @enderror"
                                   value="{{ old('absensi', $kurir->absensi) }}"
                                   min="0" max="100" required>
                            @error('absensi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Etika (0–5) *</label>
                            <input type="number" step="0.1"
                                   name="etika"
                                   class="form-control @error('etika') is-invalid @enderror"
                                   value="{{ old('etika', $kurir->etika) }}"
                                   min="0" max="5" required>
                            @error('etika')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>
                            <option value="aktif" {{ old('status', $kurir->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="nonaktif" {{ old('status', $kurir->status) == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kurir.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
