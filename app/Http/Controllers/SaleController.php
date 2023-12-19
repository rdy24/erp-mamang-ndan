<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\QuotationTemplate;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->get();
        return view('pages.sale.index', [
            'sales' => $sales,
        ]);
    }

    public function quotationCreate()
    {
        $products = Product::all();
        $customers = Customer::all();
        $templates = QuotationTemplate::all();

        $data = [
            'products' => $products,
            'customers' => $customers,
            'templates' => $templates,
        ];
        return view('pages.sale.quotation-create', $data);
    }

    public function quotationStore(Request $request)
    {
        DB::transaction(function () use ($request) {
            $sale = Sale::create([
                'kode_sales' => Sale::setKodeSale(),
                'customer_id' => $request->customer_id,
                'expired' => $request->expired_date,
                'status' => 'Quotation',
            ]);

            foreach ($request->id_produk as $key => $value) {
                $sale->sale_details()->create([
                    'product_id' => $value,
                    'qty' => $request->jumlah[$key],
                    'harga' => $request->total_harga[$key],
                ]);
            }
        });

        $saleId = Sale::orderBy('id', 'desc')->first()->id;

        return redirect()->route('dashboard.sale.quotation.show', $saleId)->with('success', 'Quotation berhasil ditambahkan');
    }

    public function quotationShow(Sale $sale)
    {
        return view('pages.sale.show', [
            'sale' => $sale,
        ]);
    }

    public function quotationEdit(Sale $sale)
    {
        $products = Product::all();
        $customers = Customer::all();

        $data = [
            'sale' => $sale,
            'products' => $products,
            'customers' => $customers,
        ];
        return view('pages.sale.quotation-edit', $data);
    }

    public function quotationUpdate(Request $request, Sale $sale)
    {
        DB::transaction(function () use ($request, $sale) {
            $sale->update([
                'customer_id' => $request->customer_id,
                'expired' => $request->expired_date,
            ]);

            $sale->sale_details()->delete();

            foreach ($request->id_produk as $key => $value) {
                $sale->sale_details()->create([
                    'product_id' => $value,
                    'qty' => $request->jumlah[$key],
                    'harga' => $request->harga[$key],
                ]);
            }
        });

        return redirect()->route('dashboard.sale.index')->with('success', 'Quotation berhasil diupdate');
    }

    public function quotationDestroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('dashboard.sale.index')->with('success', 'Quotation berhasil dihapus');
    }

    public function quotationConfirm(Sale $sale)
    {
        $sale->update([
            'status' => 'Sales Order',
        ]);

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Quotation berhasil dikonfirmasi');
    }

    public function sendQuotation(Sale $sale, Request $request)
    {
        $notification = new \App\Notifications\QuotationNotification($sale);

        $sale->customer->notify($notification);

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Quotation berhasil dikirim');
    }

    public function print(Sale $sale)
    {
        $pdf = Pdf::loadView('pages.sale.quotation-print', ['sale' => $sale]);
        // return view('pages.sale.quotation-print', ['sale' => $sale]);
    }

    public function createInvoice(Sale $sale)
    {
        $sale->update([
            'status' => 'Invoice',
            'invoice_status' => 'Draft',
        ]);

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Invoice berhasil dibuat');
    }

    public function confirmInvoice(Sale $sale)
    {
        $sale->update([
            'invoice_status' => 'Posted',
        ]);

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Invoice berhasil dikonfirmasi');
    }

    public function saleStorePayment(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        DB::transaction(function () use ($data, $request, $sale) {

            $payment = Payment::create([
                'kode_payment' => Payment::setKodePayment(),
                'sale_id' => $sale->id,
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
                'customer' => $sale->customer->nama,
                'jumlah' => $data['amount'],
                'status' => 'Debit',
                'tanggal' => $data['payment_date'],
            ]);
        });

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Invoice telah dibayar');
    }

    public function deliverProduct(Sale $sale)
    {
        $products = $sale->sale_details;

        // check if stock is enough
        foreach ($products as $product) {
            if ($product->product->jumlah < $product->qty) {
                return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('error', 'Stok ' . $product->product->nama_produk . ' tidak cukup');
            }
        }

        DB::transaction(function () use ($sale, $products) {
            $sale->update([
                'delivery_status' => 'Delivered',
            ]);

            foreach ($products as $product) {
                $product->product->update([
                    'jumlah' => $product->product->jumlah - $product->qty,
                ]);
            }
        });

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Produk berhasil dikirim');
    }

    public function printInvoice(Sale $sale)
    {
        $pdf = Pdf::loadView('pages.sale.invoice-print', ['sale' => $sale]);
        return $pdf->stream();
        // return view('pages.sale.quotation-print', ['sale' => $sale]);
    }

    public function sendInvoice(Sale $sale, Request $request)
    {
        $notification = new \App\Notifications\InvoiceNotification($sale);

        $sale->customer->notify($notification);

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Invoice berhasil dikirim');
    }


}
