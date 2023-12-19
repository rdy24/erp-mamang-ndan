<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Bill;
use App\Models\Material;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::where('status', 'RFQ')->orWhere('status', 'Purchase Order')->get();
        $isPurchaseOrder = false;
        $title = 'Request For Quotation';
        if (request()->is('dashboard/purchase-order')) {
            $purchases = Purchase::whereNotNull('bill_status')->get();
            $isPurchaseOrder = true;
            $title = 'Purchase Order';
        }
        return view('pages.purchase.index', [
            'purchases' => $purchases,
            'isPurchaseOrder' => $isPurchaseOrder,
            'title' => $title,
        ]);
    }

    public function rfqCreate()
    {
        $vendors = Vendor::all();
        $materials = Material::all();
        return view('pages.purchase.rfq-create', [
            'vendors' => $vendors,
            'materials' => $materials
        ]);
    }

    public function rfqStore(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => 'required',
            'id_bahan' => 'required',
            'jumlah' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'total_harga' => 'required',
        ]);

        DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'kode_purchase' => Purchase::setKodePurchase(),
                'vendor_id' => $data['vendor_id'],
                'status' => 'RFQ',
                'receive_status' => 'Waiting',
                'total_harga' => array_sum($data['total_harga']),
                'order_date' => now(),
            ]);

            foreach ($data['id_bahan'] as $key => $value) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'id_bahan' => $value,
                    'jumlah' => $data['jumlah'][$key],
                    'satuan' => $data['satuan'][$key],
                    'harga' => $data['harga'][$key],
                    'total_harga' => $data['total_harga'][$key],
                ]);
            }
        });

        $purchaseId = Purchase::orderBy('id', 'desc')->first()->id;

        return redirect()->route('dashboard.purchase.rfq.show', $purchaseId)->with('success', 'RFQ berhasil ditambahkan');
    }

    public function show(Purchase $purchase)
    {
        $isPurchaseOrder = false;
        $title = 'Request For Quotation';
        if (request()->is('dashboard/purchase-order/*')) {
            $isPurchaseOrder = true;
            $title = 'Purchase Order';
        }
        $bill = Bill::where('purchase_id', $purchase->id)->first();
        return view('pages.purchase.show', [
            'purchase' => $purchase,
            'bill' => $bill,
            'isPurchaseOrder' => $isPurchaseOrder,
            'title' => $title,
        ]);
    }

    public function rfqConfirm(Purchase $purchase)
    {
        $purchase->update([
            'status' => 'Purchase Order',
            'bill_status' => 'Nothing to Bill',
            'confirm_date' => now(),
        ]);

        return redirect()->route('dashboard.purchase.rfq.show', $purchase->id)->with('success', 'RFQ berhasil dikonfirmasi');
    }

    public function purchaseOrderReceive(Purchase $purchase)
    {
        $purchase->update([
            'receive_status' => 'Ready',
        ]);

        return redirect()->route('dashboard.purchase-order.show', $purchase->id)->with('success', 'Barang akan segera diterima');
    }

    public function purchaseOrderValidate(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $purchase->update([
                'receive_status' => 'Done',
                'receive_date' => now(),
                'bill_status' => 'Waiting Bills',
            ]);

            foreach ($purchase->purchaseDetails as $detail) {
                $material = Material::find($detail->id_bahan);
                $material->update([
                    'jumlah' => $material->jumlah + $detail->jumlah,
                ]);
            }
        });

        return redirect()->route('dashboard.purchase-order.show', $purchase->id)->with('success', 'Barang berhasil diterima');
    }

    public function purchaseOrderCreateBill(Purchase $purchase)
    {
        Bill::create([
            'kode_bill' => Bill::setKodeBill(),
            'purchase_id' => $purchase->id,
            'status' => 'New',
        ]);

        return redirect()->route('dashboard.purchase-order.show', $purchase->id)->with('success', 'Bill berhasil dibuat');
    }

    public function purchaseOrderStoreBill(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            'bill_date' => 'required',
            'accounting_date' => 'required',
        ]);

        $bill = Bill::where('purchase_id', $purchase->id)->first();

        $bill->update([
            'bill_date' => $data['bill_date'],
            'accounting_date' => $data['accounting_date'],
            'status' => 'Draft',
        ]);

        return redirect()->route('dashboard.purchase-order.show', $purchase->id)->with('success', 'Bill berhasil disimpan');
    }

    public function purchaseOrderPostBill(Purchase $purchase)
    {
        $bill = Bill::where('purchase_id', $purchase->id)->first();

        $bill->update([
            'status' => 'Posted',
        ]);

        return redirect()->route('dashboard.purchase-order.show', $purchase->id)->with('success', 'Bill berhasil diposting');
    }

    public function purchaseOrderStorePayment(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        $bill = Bill::where('purchase_id', $purchase->id)->first();

        DB::transaction(function () use ($data, $bill, $request, $purchase) {
            $purchase->update([
                'bill_status' => 'Fully Billed',
            ]);

            $payment = Payment::create([
                'kode_payment' => Payment::setKodePayment(),
                'bill_id' => $bill->id,
                'payment_method' => $data['type'],
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'amount' => $data['amount'],
                'payment_date' => $data['payment_date'],
                'status' => 'Paid',
            ]);

            Accounting::create([
                'payment_id' => $payment->id,
                'customer' => $purchase->vendor->nama_vendor,
                'jumlah' => $data['amount'],
                'status' => 'Kredit',
                'tanggal' => $data['payment_date'],
            ]);
        });

        return redirect()->route('dashboard.purchase-order.show', $purchase->id)->with('success', 'Bill berhasil dibayar');
    }
}
