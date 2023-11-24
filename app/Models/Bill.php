<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';

    protected $guarded = [];

    protected $casts = [
        'bill_date' => 'datetime',
        'accounting_date' => 'datetime',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public static function setKodeBill()
    {
        $lastBill = Bill::orderBy('id', 'desc')->first();
        if (! $lastBill) {
            return 'B0001';
        }

        $lastBillNumber = substr($lastBill->kode_bill, 1);
        $newBillNumber = $lastBillNumber + 1;

        return 'B' . sprintf('%04s', $newBillNumber);
    }
}
