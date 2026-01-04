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

        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
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

        // Data Kurir (27 data)
        $kurirData = [
            [
                'kode_kurir' => 'K001',
                'nama_kurir' => 'Budi Santoso',
                'jumlah_pengiriman' => 2800,
                'otd' => 98.5,
                'absensi' => 99.0,
                'etika' => 4.8,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K002',
                'nama_kurir' => 'Siti Rahayu',
                'jumlah_pengiriman' => 2200,
                'otd' => 96.0,
                'absensi' => 97.5,
                'etika' => 4.5,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K003',
                'nama_kurir' => 'Ahmad Fauzi',
                'jumlah_pengiriman' => 1900,
                'otd' => 93.5,
                'absensi' => 92.0,
                'etika' => 4.2,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K004',
                'nama_kurir' => 'Dewi Anggraini',
                'jumlah_pengiriman' => 2600,
                'otd' => 97.8,
                'absensi' => 98.5,
                'etika' => 4.7,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K005',
                'nama_kurir' => 'Rudi Hartono',
                'jumlah_pengiriman' => 1500,
                'otd' => 91.0,
                'absensi' => 88.0,
                'etika' => 3.8,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K006',
                'nama_kurir' => 'Maya Sari',
                'jumlah_pengiriman' => 2300,
                'otd' => 95.5,
                'absensi' => 96.0,
                'etika' => 4.4,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K007',
                'nama_kurir' => 'Hendra Wijaya',
                'jumlah_pengiriman' => 2700,
                'otd' => 98.2,
                'absensi' => 99.5,
                'etika' => 4.9,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K008',
                'nama_kurir' => 'Lina Marlina',
                'jumlah_pengiriman' => 1800,
                'otd' => 92.5,
                'absensi' => 90.5,
                'etika' => 4.1,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K009',
                'nama_kurir' => 'Eko Prasetyo',
                'jumlah_pengiriman' => 1200,
                'otd' => 87.0,
                'absensi' => 85.0,
                'etika' => 3.5,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K010',
                'nama_kurir' => 'Nina Rosdiana',
                'jumlah_pengiriman' => 2100,
                'otd' => 94.8,
                'absensi' => 95.0,
                'etika' => 4.3,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K011',
                'nama_kurir' => 'Agus Supriyadi',
                'jumlah_pengiriman' => 2400,
                'otd' => 96.5,
                'absensi' => 97.0,
                'etika' => 4.6,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K012',
                'nama_kurir' => 'Rina Fitriani',
                'jumlah_pengiriman' => 1700,
                'otd' => 90.5,
                'absensi' => 89.0,
                'etika' => 3.9,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K013',
                'nama_kurir' => 'Joko Susilo',
                'jumlah_pengiriman' => 2900,
                'otd' => 98.9,
                'absensi' => 99.8,
                'etika' => 4.9,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K014',
                'nama_kurir' => 'Sari Indah',
                'jumlah_pengiriman' => 1400,
                'otd' => 88.5,
                'absensi' => 87.0,
                'etika' => 3.7,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K015',
                'nama_kurir' => 'Fajar Ramadhan',
                'jumlah_pengiriman' => 2500,
                'otd' => 97.0,
                'absensi' => 98.0,
                'etika' => 4.7,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K016',
                'nama_kurir' => 'Ani Wulandari',
                'jumlah_pengiriman' => 1600,
                'otd' => 89.0,
                'absensi' => 86.5,
                'etika' => 3.6,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K017',
                'nama_kurir' => 'Bambang Surya',
                'jumlah_pengiriman' => 2250,
                'otd' => 95.8,
                'absensi' => 96.5,
                'etika' => 4.5,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K018',
                'nama_kurir' => 'Citra Dewi',
                'jumlah_pengiriman' => 1950,
                'otd' => 93.0,
                'absensi' => 91.5,
                'etika' => 4.0,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K019',
                'nama_kurir' => 'Dedi Kurniawan',
                'jumlah_pengiriman' => 1100,
                'otd' => 85.5,
                'absensi' => 82.0,
                'etika' => 3.2,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K020',
                'nama_kurir' => 'Eva Yuliana',
                'jumlah_pengiriman' => 2350,
                'otd' => 96.2,
                'absensi' => 97.2,
                'etika' => 4.6,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K021',
                'nama_kurir' => 'Firman Syah',
                'jumlah_pengiriman' => 2750,
                'otd' => 98.4,
                'absensi' => 99.2,
                'etika' => 4.8,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K022',
                'nama_kurir' => 'Gita Permata',
                'jumlah_pengiriman' => 1300,
                'otd' => 86.0,
                'absensi' => 84.0,
                'etika' => 3.4,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K023',
                'nama_kurir' => 'Hadi Pranoto',
                'jumlah_pengiriman' => 2450,
                'otd' => 97.2,
                'absensi' => 98.3,
                'etika' => 4.7,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K024',
                'nama_kurir' => 'Intan Permatasari',
                'jumlah_pengiriman' => 2050,
                'otd' => 94.5,
                'absensi' => 94.0,
                'etika' => 4.2,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K025',
                'nama_kurir' => 'Kusuma Wardani',
                'jumlah_pengiriman' => 2650,
                'otd' => 98.0,
                'absensi' => 99.0,
                'etika' => 4.9,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K026',
                'nama_kurir' => 'Lukman Hakim',
                'jumlah_pengiriman' => 1850,
                'otd' => 92.0,
                'absensi' => 89.5,
                'etika' => 4.0,
                'status' => 'aktif'
            ],
            [
                'kode_kurir' => 'K027',
                'nama_kurir' => 'Mira Utami',
                'jumlah_pengiriman' => 2150,
                'otd' => 95.0,
                'absensi' => 95.5,
                'etika' => 4.4,
                'status' => 'aktif'
            ]
        ];

        foreach ($kurirData as $kurir) {
            \App\Models\Kurir::create($kurir);
        }
    }
}