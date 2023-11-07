<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingOrder extends Model
{
    use HasFactory;

    protected $table = 'manufacturing_orders';

    protected $guarded = [];

    public function bom()
    {
        return $this->belongsTo(Bom::class, 'id_bom');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public static function setKodeOrder()
    {
        $lastOrder = ManufacturingOrder::latest()->first();
        if (!$lastOrder) {
            return 'MO-0001';
        }
        $lastKodeOrder = $lastOrder->kode_order;
        $lastKodeOrder = substr($lastKodeOrder, 3);
        $lastKodeOrder = (int) $lastKodeOrder;
        $lastKodeOrder++;
        $lastKodeOrder = 'MO-' . sprintf("%04d", $lastKodeOrder);
        return $lastKodeOrder;
    }

    public function manufacturingOrderDetails()
    {
        return $this->hasMany(ManufacturingOrderDetail::class, 'id_manufacturing_order');
    }
}
