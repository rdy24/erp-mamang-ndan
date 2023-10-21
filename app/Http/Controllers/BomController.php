<?php

namespace App\Http\Controllers;

use App\Http\Requests\BomRequest;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;
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

        return redirect()->route('dashboard.bom')->with('success', 'BOM berhasil ditambahkan');
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
}
