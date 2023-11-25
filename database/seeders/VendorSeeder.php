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

        $vendorName = [
            'PT. Makmur Jaya',
            'PT. Jaya Abadi',
            'PT. Jaya Makmur',
            'PT. Abadi Makmur',
            'PT. Abadi Jaya',
        ];

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'kode_vendor' =>  Vendor::setKodeVendor(),
                'name' => $vendorName[$i],
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'type' => 'company',
            ];

            \App\Models\Vendor::create($data);
        }
    }
}
