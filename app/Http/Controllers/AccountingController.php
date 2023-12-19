<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        $accountings = Accounting::all();

        return view('accountings.index', compact('accountings'));
    }
}
