<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $guarded = [];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public static function setKodePayment()
    {
        $lastPayment = Payment::orderBy('id', 'desc')->first();
        if (! $lastPayment) {
            return 'PY0001';
        }

        $lastPaymentNumber = substr($lastPayment->kode_payment, 2);
        $newPaymentNumber = $lastPaymentNumber + 1;

        return 'PY' . sprintf('%04s', $newPaymentNumber);
    }
}
