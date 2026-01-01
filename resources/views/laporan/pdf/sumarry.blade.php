<!DOCTYPE html>
<html>
<head>
    <title>Laporan Ringkasan - {{ $periode }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #1a237e; margin: 0; }
        .header p { color: #666; }
        .summary-box { 
            border: 2px solid #1a237e; 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 5px;
        }
        .summary-box h3 { color: #1a237e; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #1a237e; color: white; }
        .best-courier { 
            background-color: #fff3cd; 
            border: 2px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DSS Kurir GoTo</h1>
        <h3>Laporan Ringkasan Performa Kurir</h3>
        <p>Periode: {{ date('F Y', strtotime($periode . '-01')) }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="summary-box">
        <h3>Ringkasan Statistik</h3>
        <table>
            <tr>
                <td width="50%"><strong>Total Kurir Dinilai:</strong></td>
                <td>{{ $summary['total_kurir'] }} kurir</td>
            </tr>
            <tr>
                <td><strong>Rata-rata Nilai Akhir:</strong></td>
                <td>{{ number_format($summary['rata_rata'], 4) }}</td>
            </tr>
            <tr>
                <td><strong>Periode Evaluasi:</strong></td>
                <td>{{ date('F Y', strtotime($periode . '-01')) }}</td>
            </tr>
        </table>
    </div>
    
    @if($summary['kurir_terbaik'])
    <div class="best-courier">
        <h3>⭐ KURIR TERBAIK PERIODE INI</h3>
        <table>
            <tr>
                <td width="30%"><strong>Nama Kurir:</strong></td>
                <td>{{ $summary['kurir_terbaik']->kurir->nama_kurir }}</td>
            </tr>
            <tr>
                <td><strong>Kode Kurir:</strong></td>
                <td>{{ $summary['kurir_terbaik']->kurir->kode_kurir }}</td>
            </tr>
            <tr>
                <td><strong>Total Nilai:</strong></td>
                <td>{{ number_format($summary['kurir_terbaik']->total_nilai, 4) }}</td>
            </tr>
            <tr>
                <td><strong>Ranking:</strong></td>
                <td>#{{ $summary['kurir_terbaik']->ranking }}</td>
            </tr>
            <tr>
                <td><strong>Performa:</strong></td>
                <td>
                    - Jumlah Pengiriman: {{ number_format($summary['kurir_terbaik']->kurir->jumlah_pengiriman) }} paket<br>
                    - OTD Rate: {{ number_format($summary['kurir_terbaik']->kurir->otd, 1) }}%<br>
                    - Absensi: {{ number_format($summary['kurir_terbaik']->kurir->absensi, 1) }}%<br>
                    - Etika: {{ number_format($summary['kurir_terbaik']->kurir->etika, 1) }}
                </td>
            </tr>
        </table>
    </div>
    @endif
    
    <h4>Metode Penilaian (SMART)</h4>
    <p>Sistem menggunakan metode Simple Multi-Attribute Rating Technique (SMART) dengan 4 kriteria:</p>
    <ol>
        <li><strong>Jumlah Pengiriman (35%):</strong> Mengukur produktivitas kurir</li>
        <li><strong>On-Time Delivery Rate (25%):</strong> Mengukur ketepatan waktu pengiriman</li>
        <li><strong>Absensi/Kehadiran (20%):</strong> Mengukur kedisiplinan kehadiran</li>
        <li><strong>Etika (20%):</strong> Mengukur perilaku dan etika kerja</li>
    </ol>
    
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem DSS Kurir GoTo</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>