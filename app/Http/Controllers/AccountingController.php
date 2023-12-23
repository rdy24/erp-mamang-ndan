<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index(Request $request)
    {
        $accountings = Accounting::with(['payment', 'payment.bill', 'payment.sale']);

        if ($request->has('status')) {
            $accountings->where('status', 'like', "%" . $request->status . "%");
        }

        $accountings = $accountings->get();

        $debit = $accountings->where('status', 'Debit')->sum(function ($item) {
            return (int)str_replace(['Rp.', '.', ','], '', $item->jumlah);
        });

        $kredit = $accountings->where('status', 'Kredit')->sum(function ($item) {
            return (int)str_replace(['Rp.', '.', ','], '', $item->jumlah);
        });

        $total = $accountings->sum(function ($item) {
            return (int)str_replace(['Rp.', '.', ','], '', $item->jumlah);
        });

        $debit = 'Rp. ' . number_format($debit, 0, ',', '.');
        $kredit = 'Rp. ' . number_format($kredit, 0, ',', '.');
        $total = 'Rp. ' . number_format($total, 0, ',', '.');

        return view('pages.accounting.index', [
            'accountings' => $accountings,
            'debit' => $debit,
            'kredit' => $kredit,
            'total' => $total,
        ]);
    }
}
