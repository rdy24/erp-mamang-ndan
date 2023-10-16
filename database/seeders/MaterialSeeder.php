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

        for ($i = 0; $i < 10; $i++) {
            Material::create([
                'kode_bahan' => 'B' . $faker->unique()->randomNumber(4),
                'nama_bahan' => 'Bawang ' . $faker->unique()->word(),
                'harga' => $faker->randomNumber(5),
                'jumlah' => $faker->randomNumber(2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
