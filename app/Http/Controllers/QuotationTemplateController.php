<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\QuotationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationTemplateController extends Controller
{
    public function index()
    {
        $templates = QuotationTemplate::all();
        return view('pages.quotation-template.index', [
            'templates' => $templates,
        ]);
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.quotation-template.create', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $template = QuotationTemplate::create([
                'title' => $request->title,
                'expired' => $request->expired,
            ]);

            foreach ($request->id_produk as $key => $value) {
                $template->template_details()->create([
                    'product_id' => $value,
                    'qty' => $request->jumlah[$key],
                ]);
            }
        });

        return redirect()->route('dashboard.quotation-template.index')->with('success', 'Quotation Template berhasil ditambahkan');
    }

    public function show(QuotationTemplate $template)
    {
        return view('pages.quotation-template.show', [
            'template' => $template,
        ]);
    }

    public function edit(QuotationTemplate $template)
    {
        $products = Product::all();
        return view('pages.quotation-template.edit', [
            'template' => $template,
            'products' => $products,
        ]);
    }

    public function update(Request $request, QuotationTemplate $template)
    {
        DB::transaction(function () use ($request, $template) {
            $template->update([
                'title' => $request->title,
                'expired' => $request->expired,
            ]);

            $template->template_details()->delete();

            foreach ($request->id_produk as $key => $value) {
                $template->template_details()->create([
                    'product_id' => $value,
                    'qty' => $request->jumlah[$key],
                ]);
            }
        });

        return redirect()->route('dashboard.quotation-template.index')->with('success', 'Quotation Template berhasil diupdate');
    }


    public function destroy(QuotationTemplate $template)
    {
        $template->delete();
        return redirect()->route('dashboard.quotation-template.index')->with('success', 'Quotation Template berhasil dihapus');
    }

    public function getTemplate($id)
    {
        $template = QuotationTemplate::with('template_details')->find($id);

        return response()->json($template);
    }
}
