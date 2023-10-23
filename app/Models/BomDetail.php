<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomDetail extends Model
{
    use HasFactory;

    protected $table = 'bom_details';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_bahan');
    }

    public function bom()
    {
        return $this->belongsTo(Bom::class, 'id_bom');
    }

    public function getSubtotalAttribute()
    {
        $covertedJumlah = 0;

        if ($this->satuan == 'gram') {
            $covertedJumlah = gramToKg($this->jumlah);
        } else if ($this->satuan == 'ml') {
            $covertedJumlah = mlToLiter($this->jumlah);
        } else {
            $covertedJumlah = $this->jumlah;
        }
        return $covertedJumlah * $this->material->harga;
    }

    public function getTotalHargaAttribute()
    {
        return $this->bom->bomDetail->sum('subtotal');
    }
}
