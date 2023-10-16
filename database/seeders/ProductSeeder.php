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

        // insert data dummy products
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'kode_produk' => 'S' . $faker->unique()->randomNumber(4),
                'nama_produk' => 'Seblak ' . $faker->unique()->word(),
                'harga' => $faker->randomNumber(5),
                'jumlah' => $faker->randomNumber(2),
                'deskripsi' => $faker->text,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
