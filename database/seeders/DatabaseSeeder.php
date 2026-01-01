<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kriteria;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@gotokurir.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // Create Supervisor User
        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@gotokurir.com',
            'password' => bcrypt('super123'),
            'role' => 'supervisor'
        ]);

        // Create Manager User
        User::create([
            'name' => 'Manager',
            'email' => 'manager@gotokurir.com',
            'password' => bcrypt('manager123'),
            'role' => 'manager'
        ]);

        // Create Kriteria SMART
        $kriteria = [
            [
                'kode' => 'C1',
                'nama_kriteria' => 'Jumlah Pengiriman',
                'bobot' => 35.00,
                'jenis' => 'benefit',
                'keterangan' => 'Skor 5 = ≥ 2500 paket, Skor 4 = 2000 – 2500 paket, Skor 3 = 1500– 1999 paket, Skor 2 = 1000 – 1499 paket, Skor 1 = < 1000 paket'
            ],
            [
                'kode' => 'C2',
                'nama_kriteria' => 'On-Time Delivery Rate',
                'bobot' => 25.00,
                'jenis' => 'benefit',
                'keterangan' => 'Skor 5 = ≥ 97%, Skor 4 = 95 – 97%, Skor 3 = 90 – 94%, Skor 2 = 80 – 89%, Skor 1 = < 80%'
            ],
            [
                'kode' => 'C3',
                'nama_kriteria' => 'Absensi/Kehadiran',
                'bobot' => 20.00,
                'jenis' => 'benefit',
                'keterangan' => 'Skor 5 = 100%, Skor 4 = 95 – 99%, Skor 3 = 85 – 94%, Skor 2 = 70 – 84%, Skor 1 = < 70%'
            ],
            [
                'kode' => 'C4',
                'nama_kriteria' => 'Etika',
                'bobot' => 20.00,
                'jenis' => 'benefit',
                'keterangan' => 'Skor 5 = Nilai 4.6 – 5.0, Skor 4 = Nilai 4.0 – 4.5, Skor 3 = Nilai 3.0 – 3.9, Skor 2 = Nilai 2.0 – 2.9, Skor 1 = Nilai < 2.0'
            ]
        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }

        // Sample Data Kurir
        \App\Models\Kurir::create([
            'kode_kurir' => 'K001',
            'nama_kurir' => 'Budi Santoso',
            'jumlah_pengiriman' => 2800,
            'otd' => 98.5,
            'absensi' => 99.0,
            'etika' => 4.8,
            'status' => 'aktif'
        ]);

        \App\Models\Kurir::create([
            'kode_kurir' => 'K002',
            'nama_kurir' => 'Siti Rahayu',
            'jumlah_pengiriman' => 2200,
            'otd' => 96.0,
            'absensi' => 97.5,
            'etika' => 4.5,
            'status' => 'aktif'
        ]);
    }
}