<?php

namespace Database\Seeders;

use App\Models\Bom;
use App\Models\BomDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_bom' => 'BOM001',
                'id_produk' => 1,
                'detail' => [
                    [
                        'id_bahan' => 1,
                        'jumlah' => 100,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 10,
                        'jumlah' => 50,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 16,
                        'jumlah' => 15,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 3,
                        'jumlah' => 39,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 17,
                        'jumlah' => 150,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 6,
                        'jumlah' => 15,
                        'satuan' => 'ml',
                    ],
                    [
                        'id_bahan' => 13,
                        'jumlah' => 500,
                        'satuan' => 'ml',
                    ],
                    [
                        'id_bahan' => 11,
                        'jumlah' => 60,
                        'satuan' => 'gram',
                    ],
                ],
            ],
            [
                'kode_bom' => 'BOM002',
                'id_produk' => 2,
                'detail' => [
                    [
                        'id_bahan' => 2,
                        'jumlah' => 500,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 14,
                        'jumlah' => 30,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 10,
                        'jumlah' => 50,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 9,
                        'jumlah' => 15,
                        'satuan' => 'ml',
                    ],
                    [
                        'id_bahan' => 15,
                        'jumlah' => 0.30,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 12,
                        'jumlah' => 28,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 13,
                        'jumlah' => 500,
                        'satuan' => 'ml',
                    ],
                    [
                        'id_bahan' => 11,
                        'jumlah' => 60,
                        'satuan' => 'gram',
                    ],
                ],
            ],
            [
                'kode_bom' => 'BOM003',
                'id_produk' => 3,
                'detail' => [
                    [
                        'id_bahan' => 3,
                        'jumlah' => 325,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 6,
                        'jumlah' => 15,
                        'satuan' => 'ml',
                    ],
                    [
                        'id_bahan' => 10,
                        'jumlah' => 50,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 4,
                        'jumlah' => 50,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 5,
                        'jumlah' => 50,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 12,
                        'jumlah' => 28,
                        'satuan' => 'gram',
                    ],
                    [
                        'id_bahan' => 13,
                        'jumlah' => 500,
                        'satuan' => 'ml',
                    ],
                    [
                        'id_bahan' => 11,
                        'jumlah' => 60,
                        'satuan' => 'gram',
                    ],
                ],
            ],
        ];

        foreach ($data as $key => $value) {
            $bom = Bom::create([
                'kode_bom' => $value['kode_bom'],
                'id_produk' => $value['id_produk'],
            ]);

            foreach ($value['detail'] as $key => $value) {
                BomDetail::create([
                    'id_bom' => $bom->id,
                    'id_bahan' => $value['id_bahan'],
                    'jumlah' => $value['jumlah'],
                    'satuan' => $value['satuan'],
                ]);
            }
        }
    }
}
