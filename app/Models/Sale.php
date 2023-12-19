<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected  $guarded = [];

    protected $table = 'sales';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',	
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function setKodeSale()
    {
        $lastSale = Sale::orderBy('id', 'desc')->first();
        if (! $lastSale) {
            return 'S0001';
        }

        $lastSaleNumber = substr($lastSale->kode_sales, 1);
        $newSaleNumber = $lastSaleNumber + 1;

        return 'S' . sprintf('%04s', $newSaleNumber);
    }

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getTotalAttribute()
    {
        return $this->sale_details->sum(function ($detail) {
            return $detail->qty * $detail->product->harga;
        });
    }

    
}
