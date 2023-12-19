<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'customer',
        'jumlah',
        'status',
        'tanggal',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function getJumlahAttribute($value)
    {
        return 'Rp.' . number_format($value, 0, ',', '.');
    }
}
