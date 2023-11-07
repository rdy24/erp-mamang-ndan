<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'manufacturing_order_details';

    protected $guarded = [];

    public function manufacturingOrder()
    {
        return $this->belongsTo(ManufacturingOrder::class, 'id_manufacturing_order');
    }

    public function bom()
    {
        return $this->belongsTo(Bom::class, 'id_bom');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_bahan');
    }
}
