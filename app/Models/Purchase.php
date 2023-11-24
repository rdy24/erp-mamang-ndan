<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'order_date' => 'datetime',
        'confirm_date' => 'datetime',
        'receive_date' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    public static function setKodePurchase()
    {
        $lastPurchase = Purchase::orderBy('id', 'desc')->first();
        if (! $lastPurchase) {
            return 'P0001';
        }

        $lastPurchaseNumber = substr($lastPurchase->kode_purchase, 1);
        $newPurchaseNumber = $lastPurchaseNumber + 1;

        return 'P' . sprintf('%04s', $newPurchaseNumber);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->purchaseDetails as $detail) {
            $total += $detail->total_harga;
        }

        return $total;
    }
}
