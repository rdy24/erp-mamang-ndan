<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // faker id
        $faker = \Faker\Factory::create('id_ID');

        $data = [
            [
                'id' => 1,
                'kode_produk' => 'PR0001',
                'nama_produk' => 'Seblak Makaroni',
                'harga' => 22500,
                'jumlah' => 0,
                'deskripsi' => 'Seblak dengan topping makaroni',
            ],
            [
                'id' => 2,
                'kode_produk' => 'PR0002',
                'nama_produk' => 'Seblak Ceker Ayam',
                'harga' => 17500,
                'jumlah' => 0,
                'deskripsi' => 'Seblak dengan ceker ayam',
            ],
            [
                'id' => 3,
                'kode_produk' => 'PR0003',
                'nama_produk' => 'Seblak Bakso',
                'harga' => 21500,
                'jumlah' => 0,
                'deskripsi' => 'Seblak dengan bakso',
            ],
        ];

        foreach ($data as $key => $value) {
            Product::create([
                'kode_produk' => $value['kode_produk'],
                'nama_produk' => $value['nama_produk'],
                'harga' => $value['harga'],
                'jumlah' => $value['jumlah'],
                'deskripsi' => $value['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
