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
        $lastVendor = Vendor::latest()->first();
        if (!$lastVendor) {
            return 'VN-0001';
        }
        $lastKodeVendor = $lastVendor->kode_vendor;
        $lastKodeVendor = substr($lastKodeVendor, 3);
        $lastKodeVendor = (int) $lastKodeVendor;
        $lastKodeVendor++;
        $lastKodeVendor = 'VN-' . sprintf("%04d", $lastKodeVendor);
        return $lastKodeVendor;
    }
}
