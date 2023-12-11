<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
                'expired' => $request->expired,
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
                'expired' => $request->expired,
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
        ]);

        return redirect()->route('dashboard.sale.quotation.show', $sale->id)->with('success', 'Invoice berhasil dibuat');
    }
}
