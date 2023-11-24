<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 7; $i++) {
            $data = [
                'kode_vendor' =>  Vendor::setKodeVendor(),
                'name' => $faker->name,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'type' => $faker->randomElement(['individual', 'company']),
            ];

            \App\Models\Vendor::create($data);
        }
    }
}
