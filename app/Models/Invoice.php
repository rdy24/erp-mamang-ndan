<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $guarded = [];
    
    protected $casts = [
        'invoice_date' => 'datetime',
        'accounting_date' => 'datetime',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public static function setKodeInvoice()
    {
        $latest = Invoice::whereYear('created_at', date('Y'))->latest()->first();

        if (!$latest) {
            $number = 1;
        } else {
            $number = (int)substr($latest->kode_invoice, -3) + 1;
        }

        $number = str_pad($number, 3, '0', STR_PAD_LEFT);

        return 'INV/' . date('Y/m/') . $number;
    }
}
