@extends('layouts.app')

@section('title', 'Data Periode')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i> Data Periode
            </h5>
            <a href="{{ route('periode.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Periode
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Periode</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Jumlah Kurir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periodes as $periode)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $periode->nama_periode }}</strong>
                            @if($periode->is_active)
                            <span class="badge bg-success ms-1">Aktif</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $periode->status == 'berjalan' ? 'info' : ($periode->status == 'selesai' ? 'success' : 'secondary') }}">
                                {{ ucfirst($periode->status) }}
                            </span>
                        </td>
                        <td>{{ Str::limit($periode->keterangan, 50) }}</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $periode->kurirs_count ?? 0 }} Kurir
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('periode.edit', $periode->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#detailModal{{ $periode->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(!$periode->is_active)
                                <form action="{{ route('periode.activate', $periode->id) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Aktifkan periode ini? Periode aktif saat ini akan dinonaktifkan.')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success" title="Aktifkan Periode">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('periode.destroy', $periode->id) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Hapus periode ini? Data terkait juga akan terhapus.')">
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
@foreach($periodes as $periode)
<div class="modal fade" id="detailModal{{ $periode->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Periode: {{ $periode->nama_periode }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Periode</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Nama Periode</th>
                                <td>{{ $periode->nama_periode }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td>{{ \Carbon\Carbon::parse($periode->tanggal_mulai)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>{{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Durasi</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->diffInDays($periode->tanggal_selesai) + 1 }} hari
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Status & Keterangan</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Status</th>
                                <td>
                                    <span class="badge bg-{{ $periode->status == 'berjalan' ? 'info' : ($periode->status == 'selesai' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($periode->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Aktif</th>
                                <td>
                                    @if($periode->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                    @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Kurir</th>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $periode->kurirs_count ?? 0 }} Kurir
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6 class="mt-3">Keterangan</h6>
                <div class="card">
                    <div class="card-body">
                        {{ $periode->keterangan ?? 'Tidak ada keterangan' }}
                    </div>
                </div>

                @if($periode->kurirs_count > 0)
                <h6 class="mt-3">Data Kurir dalam Periode</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kode Kurir</th>
                                <th>Nama Kurir</th>
                                <th>Pengiriman</th>
                                <th>OTD</th>
                                <th>Absensi</th>
                                <th>Etika</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periode->kurirs as $kurir)
                            <tr>
                                <td>{{ $kurir->kode_kurir }}</td>
                                <td>{{ $kurir->nama_kurir }}</td>
                                <td>{{ number_format($kurir->jumlah_pengiriman) }}</td>
                                <td>{{ number_format($kurir->otd, 1) }}%</td>
                                <td>{{ number_format($kurir->absensi, 1) }}%</td>
                                <td>{{ number_format($kurir->etika, 1) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i> Belum ada data kurir dalam periode ini.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                @if($periode->kurirs_count == 0 && !$periode->is_active)
                <form action="{{ route('periode.copy', $periode->id) }}" method="POST" class="me-auto">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-copy me-1"></i> Copy Kurir dari Periode Sebelumnya
                    </button>
                </form>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    // Auto update status berdasarkan tanggal
    function updatePeriodeStatus() {
        fetch('{{ route("periode.update-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.updated) {
                location.reload();
            }
        });
    }
    
    // Update status setiap 5 menit
    setInterval(updatePeriodeStatus, 300000);
</script>
@endpush