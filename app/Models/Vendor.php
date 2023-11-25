<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'vendors';

    public static function setKodeVendor()
    {
        $lastVendor = Vendor::orderBy('id', 'desc')->first();
        if (! $lastVendor) {
            return 'V0001';
        }

        $lastVendorNumber = substr($lastVendor->kode_vendor, 1);
        $newVendorNumber = $lastVendorNumber + 1;

        return 'V' . sprintf('%04s', $newVendorNumber);
    }
}
