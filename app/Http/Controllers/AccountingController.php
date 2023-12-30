<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index(Request $request)
    {
        $accountings = Accounting::with(['payment', 'payment.bill', 'payment.invoice']);

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

        if ($debit > $kredit) {
            $saldo = $debit - $kredit;
            $keterangan = 'Untung Sebesar Rp. ' . number_format($saldo, 0, ',', '.');
        } else {
            $saldo = $kredit - $debit;
            $keterangan = 'Rugi Sebesar Rp. ' . number_format($saldo, 0, ',', '.');
        }

        $debit = 'Rp. ' . number_format($debit, 0, ',', '.');
        $kredit = 'Rp. ' . number_format($kredit, 0, ',', '.');
        $total = 'Rp. ' . number_format($total, 0, ',', '.');

        return view('pages.accounting.index', [
            'accountings' => $accountings,
            'debit' => $debit,
            'kredit' => $kredit,
            'total' => $total,
            'keterangan' => $keterangan,
        ]);
    }

    public function print()
    {
        $accountings = Accounting::with(['payment', 'payment.bill', 'payment.invoice'])->get();

        $totalDebit = $accountings->where('status', 'Debit')->sum(function ($item) {
            return (int)str_replace(['Rp.', '.', ','], '', $item->jumlah);
        });

        $totalKredit = $accountings->where('status', 'Kredit')->sum(function ($item) {
            return (int)str_replace(['Rp.', '.', ','], '', $item->jumlah);
        });

        $total = $accountings->sum(function ($item) {
            return (int)str_replace(['Rp.', '.', ','], '', $item->jumlah);
        });

        $debit = $accountings->where('status', 'Debit');
        $kredit = $accountings->where('status', 'Kredit');

        $totalDebitFormatted = 'Rp. ' . number_format($totalDebit, 0, ',', '.');
        $totalKreditFormatted = 'Rp. ' . number_format($totalKredit, 0, ',', '.');
        $totalFormatted = 'Rp. ' . number_format($total, 0, ',', '.');

        if ($totalDebit > $totalKredit) {
            $saldo = $totalDebit - $totalKredit;
            $keterangan = 'Untung Sebesar Rp. ' . number_format($saldo, 0, ',', '.');
        } else {
            $saldo = $totalKredit - $totalDebit;
            $keterangan = 'Rugi Sebesar Rp. ' . number_format($saldo, 0, ',', '.');
        }


        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.accounting.print', [
            'debit' => $debit,
            'kredit' => $kredit,
            'totalDebit' => $totalDebitFormatted,
            'totalKredit' => $totalKreditFormatted,
            'total' => $totalFormatted,
            'keterangan' => $keterangan,
        ]);

        return $pdf->stream('laporan-keuangan.pdf');
    }


}
