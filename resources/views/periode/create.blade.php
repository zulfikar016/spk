@extends('layouts.app')

@section('title', 'Tambah Periode Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-calendar-plus me-2"></i> Tambah Periode Baru
            </h5>
            <a href="{{ url('/periode') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ url('/periode/store') }}" method="POST" id="periodeForm">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_periode" class="form-label">
                            <i class="fas fa-font me-1 text-primary"></i> Nama Periode
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_periode') is-invalid @enderror" 
                               id="nama_periode" 
                               name="nama_periode" 
                               value="{{ old('nama_periode') }}"
                               placeholder="Contoh: Periode Januari 2024"
                               required>
                        @error('nama_periode')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i> Berikan nama yang jelas untuk periode ini
                        </small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">
                            <i class="fas fa-calendar-day me-1 text-primary"></i> Tanggal Mulai
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                               id="tanggal_mulai" 
                               name="tanggal_mulai" 
                               value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                               required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">
                            <i class="fas fa-calendar-check me-1 text-primary"></i> Tanggal Selesai
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                               id="tanggal_selesai" 
                               name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai') }}"
                               required>
                        @error('tanggal_selesai')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i> Harus setelah tanggal mulai
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">
                    <i class="fas fa-sticky-note me-1 text-primary"></i> Keterangan
                </label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                          id="keterangan" 
                          name="keterangan" 
                          rows="3"
                          placeholder="Tambahkan keterangan atau catatan penting mengenai periode ini...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle text-info me-2"></i> Info Periode
                            </h6>
                            <div class="mb-2">
                                <small class="text-muted">Status Default:</small>
                                <div>
                                    <span class="badge bg-secondary">Belum Dimulai</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Status Aktif:</small>
                                <div>
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                    <small class="text-muted d-block">
                                        Dapat diaktifkan nanti melalui halaman daftar periode
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-history me-2"></i> Periode Terakhir
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($lastPeriode)
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $lastPeriode->nama_periode }}</strong>
                                    @if($lastPeriode->is_active)
                                    <span class="badge bg-success ms-2">Aktif</span>
                                    @endif
                                </div>
                                <div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($lastPeriode->tanggal_mulai)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($lastPeriode->tanggal_selesai)->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Jumlah Kurir:</small>
                                <span class="badge bg-primary">{{ $lastPeriode->kurirs_count ?? 0 }}</span>
                            </div>
                            @else
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                <p>Belum ada periode sebelumnya</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">
                                <i class="fas fa-check-circle text-success me-2"></i> Konfirmasi
                            </h6>
                            <small class="text-muted">Pastikan data yang dimasukkan sudah benar</small>
                        </div>
                        <div class="btn-group">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Periode
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i> Preview Periode
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <tr>
                        <th width="40%">Nama Periode</th>
                        <td id="previewNama"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td id="previewMulai"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td id="previewSelesai"></td>
                    </tr>
                    <tr>
                        <th>Durasi</th>
                        <td id="previewDurasi"></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td id="previewKeterangan"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="periodeForm" class="btn btn-primary">
                    <i class="fas fa-check me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .card {
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 0.375rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Format tanggal untuk preview
    function formatTanggal(tanggal) {
        const date = new Date(tanggal);
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }
    
    // Hitung durasi
    function hitungDurasi(mulai, selesai) {
        const start = new Date(mulai);
        const end = new Date(selesai);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays + ' hari';
    }
    
    // Validasi tanggal
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        const tanggalMulai = this.value;
        const tanggalSelesai = document.getElementById('tanggal_selesai').value;
        
        if (tanggalSelesai && tanggalMulai > tanggalSelesai) {
            document.getElementById('tanggal_selesai').value = '';
            showToast('Tanggal selesai harus setelah tanggal mulai', 'warning');
        }
    });
    
    // Preview sebelum submit
    document.getElementById('periodeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const nama = document.getElementById('nama_periode').value;
        const mulai = document.getElementById('tanggal_mulai').value;
        const selesai = document.getElementById('tanggal_selesai').value;
        const keterangan = document.getElementById('keterangan').value;
        
        // Validasi required
        if (!nama || !mulai || !selesai) {
            showToast('Harap isi semua field yang wajib diisi', 'warning');
            return;
        }
        
        // Validasi tanggal
        if (mulai > selesai) {
            showToast('Tanggal selesai harus setelah tanggal mulai', 'warning');
            return;
        }
        
        // Set preview data
        document.getElementById('previewNama').textContent = nama || '-';
        document.getElementById('previewMulai').textContent = formatTanggal(mulai);
        document.getElementById('previewSelesai').textContent = formatTanggal(selesai);
        document.getElementById('previewDurasi').textContent = hitungDurasi(mulai, selesai);
        document.getElementById('previewKeterangan').textContent = keterangan || 'Tidak ada keterangan';
        
        // Show modal preview
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    });
    
    // Function untuk show toast
    function showToast(message, type = 'info') {
        // Buat toast element
        const toastContainer = document.getElementById('toastContainer') || createToastContainer();
        const toastId = 'toast-' + Date.now();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type === 'warning' ? 'warning' : 'info'} border-0`;
        toast.id = toastId;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas ${type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Inisialisasi dan show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Hapus toast setelah ditutup
        toast.addEventListener('hidden.bs.toast', function () {
            toast.remove();
        });
    }
    
    // Buat container untuk toast jika belum ada
    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '1060';
        document.body.appendChild(container);
        return container;
    }
    
    // Set minimum date untuk tanggal selesai
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        const minDate = this.value;
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        tanggalSelesai.min = minDate;
        
        // Jika tanggal selesai sudah diisi tetapi kurang dari tanggal mulai, reset
        if (tanggalSelesai.value && tanggalSelesai.value < minDate) {
            tanggalSelesai.value = '';
        }
    });
</script>
@endpush