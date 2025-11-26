<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Masakan;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Create demo masakan
        $masakans = [
            [
                'nama_masakan' => 'Nasi Goreng Special',
                'kategori' => 'Makanan',
                'harga' => 35000,
                'deskripsi' => 'Nasi goreng dengan telur, ayam, sayuran dan bumbu rahasia',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_masakan' => 'Mie Ayam Bakso',
                'kategori' => 'Makanan',
                'harga' => 28000,
                'deskripsi' => 'Mie ayam dengan bakso sapi dan sayuran segar',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_masakan' => 'Ayam Bakar Madu',
                'kategori' => 'Makanan',
                'harga' => 45000,
                'deskripsi' => 'Ayam bakar dengan saus madu khas',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_masakan' => 'Es Teh Manis',
                'kategori' => 'Minuman',
                'harga' => 8000,
                'deskripsi' => 'Teh manis dingin dengan es batu',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_masakan' => 'Jus Alpukat',
                'kategori' => 'Minuman',
                'harga' => 15000,
                'deskripsi' => 'Jus alpukat segar dengan susu dan madu',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_masakan' => 'Sate Ayam',
                'kategori' => 'Makanan',
                'harga' => 38000,
                'deskripsi' => '10 tusuk sate ayam dengan bumbu kacang',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_masakan' => 'Gado-Gado',
                'kategori' => 'Makanan',
                'harga' => 22000,
                'deskripsi' => 'Sayuran segar dengan bumbu kacang dan kerupuk',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_masakan' => 'Es Campur',
                'kategori' => 'Minuman',
                'harga' => 18000,
                'deskripsi' => 'Campuran buah segar dengan susu dan sirup',
                'status_masakan' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Masakan::insert($masakans);

        // Create demo meja
        $mejas = [];
        for ($i = 1; $i <= 12; $i++) {
            $mejas[] = [
                'no_meja' => 'T' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'kapasitas' => $i <= 6 ? 4 : 6,
                'lokasi' => $i <= 6 ? 'Indoor' : 'Outdoor',
                'status_meja' => 'kosong',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Meja::insert($mejas);
    }
}
