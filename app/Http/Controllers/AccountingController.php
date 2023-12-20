<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index(Request $request)
    {

        if ($request->has('status')) {
            $accountings = Accounting::with(['payment', 'payment.bill', 'payment.sale'])->where('status', 'like', "%" . $request->status . "%")->get();
        } else {
            $accountings = Accounting::with(['payment', 'payment.bill', 'payment.sale'])->get();
        }

        return view('pages.accounting.index', compact('accountings'));
    }
}
