<?php

namespace App\Http\Controllers;

use App\Http\Requests\BomRequest;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BomController extends Controller
{
    public function index(): View
    {
        $bom = Bom::all();
        
        return view('pages.bom.index', [
            'bom' => $bom,
        ]); 
    }

    public function create(): View
    {
        $products = Product::all();
        $materials = Material::all();

        return view('pages.bom.create', [
            'products' => $products,
            'materials' => $materials,
        ]);
    }

    public function store(BomRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $bom = Bom::create([
                'kode_bom' => $data['kode_bom'],
                'id_produk' => $data['id_produk'],
            ]);

            foreach ($data['id_bahan'] as $key => $value) {
                BomDetail::create([
                    'id_bom' => $bom->id,
                    'id_bahan' => $value,
                    'jumlah' => $data['jumlah'][$key],
                    'satuan' => $data['satuan'][$key],
                ]);
            }
        });

        $bomId = Bom::latest()->first()->id;

        return redirect()->route('dashboard.bom.show', $bomId)->with('success', 'BOM berhasil ditambahkan');
    }

    public function show(Bom $bom)
    {
        $title = 'Hapus BOM';
        $text = "Apakah anda yakin ingin menghapus BOM ini?";
        confirmDelete($title, $text);
        return view('pages.bom.show', [
            'bom' => $bom,
        ]);
    }

    public function edit(Bom $bom): View
    {
        $products = Product::all();
        $materials = Material::all();

        return view('pages.bom.edit', [
            'bom' => $bom,
            'products' => $products,
            'materials' => $materials,
        ]);
    }

    public function update(BomRequest $request, Bom $bom)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $bom) {
            $bom->update([
                'kode_bom' => $data['kode_bom'],
                'id_produk' => $data['id_produk'],
            ]);

            $bomDetail = BomDetail::where('id_bom', $bom->id)->get();

            foreach ($bomDetail as $key => $value) {
                $value->update([
                    'id_bahan' => $data['id_bahan'][$key],
                    'jumlah' => $data['jumlah'][$key],
                    'satuan' => $data['satuan'][$key],
                ]);
            }
        });

        return redirect()->route('dashboard.bom.show', $bom->id)->with('success', 'BOM berhasil diubah');
    }

    public function destroy(Bom $bom)
    {
        $bom->delete();

        return redirect()->route('dashboard.bom.index')->with('success', 'BOM berhasil dihapus');
    }

    public function print(Bom $bom)
    {
        $pdf = PDF::loadview('pages.bom.print', [
            'bom' => $bom,
        ]);

        return $pdf->download('bom-' . $bom->kode_bom . '.pdf');
    }
}
