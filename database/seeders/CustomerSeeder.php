<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $customerName = [
            'PT. Sejahtera',
            'PT. Mutiara',
            'PT. Jaya',
            'PT. Abadi',
            'PT. Makmur',
        ];

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'kode_customer' =>  \App\Models\Customer::setKodeCustomer(),
                'name' => $customerName[$i],
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'type' => 'company',
            ];

            \App\Models\Customer::create($data);
        }
    }
}
