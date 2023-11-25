<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table ='products';
    protected $guarded = ['id'];

    public static function setKodeProduct()
    {
        $lastProduct = Product::orderBy('id', 'desc')->first();
        if (! $lastProduct) {
            return 'PR0001';
        }

        $lastProductNumber = substr($lastProduct->kode_produk, 2);
        $newProductNumber = $lastProductNumber + 1;

        return 'PR' . sprintf('%04s', $newProductNumber);
    }
}
