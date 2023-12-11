<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;

    protected  $guarded = [];

    protected $table = 'customers';

    public static function setKodeCustomer()
    {
        $lastCustomer = Customer::orderBy('id', 'desc')->first();
        if (! $lastCustomer) {
            return 'C0001';
        }

        $lastCustomerNumber = substr($lastCustomer->kode_customer, 1);
        $newCustomerNumber = $lastCustomerNumber + 1;

        return 'C' . sprintf('%04s', $newCustomerNumber);
    }
}
