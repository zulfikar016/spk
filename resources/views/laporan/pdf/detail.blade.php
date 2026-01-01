<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Kurir - {{ $periode }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #1a237e; margin: 0; }
        .header p { color: #666; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #1a237e; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .total { font-weight: bold; background-color: #e3f2fd; }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; color: #666; }
        .badge { padding: 3px 8px; border-radius: 3px; font-size: 12px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DSS Kurir GoTo</h1>
        <h3>Laporan Detail Ranking Kurir</h3>
        <p>Periode: {{ date('F Y', strtotime($periode . '-01')) }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <h4>Ranking Kurir</h4>
    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Kode Kurir</th>
                <th>Nama Kurir</th>
                <th>Total Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankings as $ranking)
            <tr>
                <td align="center">{{ $ranking->ranking }}</td>
                <td>{{ $ranking->kurir->kode_kurir }}</td>
                <td>{{ $ranking->kurir->nama_kurir }}</td>
                <td align="right">{{ number_format($ranking->total_nilai, 4) }}</td>
                <td align="center">
                    @if($ranking->status == '⭐ Kurir Terbaik')
                        <span class="badge badge-warning">⭐ Kurir Terbaik</span>
                    @elseif($ranking->status == 'Baik')
                        <span class="badge badge-success">Baik</span>
                    @else
                        <span class="badge badge-danger">Perlu Evaluasi</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h4>Kriteria Penilaian</h4>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Kriteria</th>
                <th>Bobot</th>
                <th>Jenis</th>
                <th>Skala Penilaian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>C1</td>
                <td>Jumlah Pengiriman</td>
                <td>35%</td>
                <td>Benefit</td>
                <td>Skor 5: ≥ 2500, 4: 2000-2500, 3: 1500-1999, 2: 1000-1499, 1: < 1000</td>
            </tr>
            <tr>
                <td>C2</td>
                <td>On-Time Delivery Rate</td>
                <td>25%</td>
                <td>Benefit</td>
                <td>Skor 5: ≥ 97%, 4: 95-97%, 3: 90-94%, 2: 80-89%, 1: < 80%</td>
            </tr>
            <tr>
                <td>C3</td>
                <td>Absensi/Kehadiran</td>
                <td>20%</td>
                <td>Benefit</td>
                <td>Skor 5: 100%, 4: 95-99%, 3: 85-94%, 2: 70-84%, 1: < 70%</td>
            </tr>
            <tr>
                <td>C4</td>
                <td>Etika</td>
                <td>20%</td>
                <td>Benefit</td>
                <td>Skor 5: 4.6-5.0, 4: 4.0-4.5, 3: 3.0-3.9, 2: 2.0-2.9, 1: < 2.0</td>
            </tr>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem DSS Kurir GoTo</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>