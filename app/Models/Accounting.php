<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'accountings';

    protected $casts = [
        'tanggal' => 'datetime',	// default format: Y-m-d H:i:s
        'created_at' => 'datetime:Y-m-d H:i:s',	
        'updated_at' => 'datetime:Y-m-d H:i:s',
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
