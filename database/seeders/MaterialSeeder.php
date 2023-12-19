<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            [
                'id' => 1,
                'kode_bahan' => 'B0001',
                'nama_bahan' => 'Makaroni',
                'harga' => 5000,
                'satuan' => 'kg',
                'jumlah' => 100,
            ],
            [
                'id' => 2,
                'kode_bahan' => 'B0002',
                'nama_bahan' => 'Ceker Ayam',
                'harga' => 10000,
                'satuan' => 'kg',
                'jumlah' => 50,
            ],
            [
                'id' => 3,
                'kode_bahan' => 'B0003',
                'nama_bahan' => 'Bakso Sapi',
                'harga' => 15000,
                'satuan' => 'kg',
                'jumlah' => 50,
            ],
            [
                'id' => 4,
                'kode_bahan' => 'B0004',
                'nama_bahan' => 'Bawang Merah',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 30,
            ],
            [
                'id' => 5,
                'kode_bahan' => 'B0005',
                'nama_bahan' => 'Bawang Putih',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 30,
            ],
            [
                'id' => 6,
                'kode_bahan' => 'B0006',
                'nama_bahan' => 'Cabai Bubuk',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 20,
            ],
            [
                'id' => 7,
                'kode_bahan' => 'B0007',
                'nama_bahan' => 'Garam',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 20,
            ],
            [
                'id' => 8,
                'kode_bahan' => 'B0008',
                'nama_bahan' => 'Gula',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 10,
            ],
            [
                'id' => 9,
                'kode_bahan' => 'B0009',
                'nama_bahan' => 'Kecap Manis',
                'harga' => 20000,
                'satuan' => 'liter',
                'jumlah' => 20,
            ],
            [
                'id' => 10,
                'kode_bahan' => 'B0010',
                'nama_bahan' => 'Telur Ayam',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 20,
            ],
            [
                'id' => 11,
                'kode_bahan' => 'B0011',
                'nama_bahan' => 'Mie',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 30,
            ],
            [
                'id' => 12,
                'kode_bahan' => 'B0012',
                'nama_bahan' => 'Daun Bawang',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 20,
            ],
            [
                'id' => 13,
                'kode_bahan' => 'B0013',
                'nama_bahan' => 'Air',
                'harga' => 20000,
                'satuan' => 'liter',
                'jumlah' => 30,
            ],
            [
                'id' => 14,
                'kode_bahan' => 'B0014',
                'nama_bahan' => 'Kerupuk Bawang',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 10,
            ],
            [
                'id' => 15,
                'kode_bahan' => 'B0015',
                'nama_bahan' => 'Lada Bubuk',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 30,
            ],
            [
                'id' => 16,
                'kode_bahan' => 'B0016',
                'nama_bahan' => 'Sosis',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 10,
            ],
            [
                'id' => 17,
                'kode_bahan' => 'B0017',
                'nama_bahan' => 'Tomat',
                'harga' => 20000,
                'satuan' => 'kg',
                'jumlah' => 20,
            ]

        ];

        foreach ($data as $key => $value) {
            Material::create([
                'id' => $value['id'],
                'kode_bahan' => $value['kode_bahan'],
                'nama_bahan' => $value['nama_bahan'],
                'harga' => $value['harga'],
                'satuan' => $value['satuan'],
                'jumlah' => $value['jumlah'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
