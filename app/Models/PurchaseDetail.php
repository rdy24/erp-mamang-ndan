<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_bahan');
    }

    public static function setKodePurchaseDetail()
    {
        $lastPurchaseDetail = PurchaseDetail::orderBy('id', 'desc')->first();
        if (! $lastPurchaseDetail) {
            return 'PD0001';
        }

        $lastPurchaseDetailNumber = substr($lastPurchaseDetail->kode_purchase_detail, 3);
        $newPurchaseDetailNumber = $lastPurchaseDetailNumber + 1;

        return 'PD' . sprintf('%04s', $newPurchaseDetailNumber);
    }
}
