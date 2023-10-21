<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;

    protected $table = 'boms';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function bomDetail()
    {
        return $this->hasMany(BomDetail::class, 'id_bom');
    }
}
