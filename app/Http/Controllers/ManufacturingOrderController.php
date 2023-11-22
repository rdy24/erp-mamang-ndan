<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\ManufacturingOrder;
use App\Models\ManufacturingOrderDetail;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManufacturingOrderController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $orders = ManufacturingOrder::all();
        return view('pages.manufacturing-order.index', [
            'orders' => $orders,
        ]);
    }

    public function create(): \Illuminate\View\View
    {
        $products = Product::all();
        $bom = Bom::all();
        return view('pages.manufacturing-order.create', [
            'products' => $products,
            'bom' => $bom,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_produk' => 'required',
            'id_bom' => 'required',
            'jumlah_order' => 'required',
            'id_bahan' => 'required',
            'jumlah_bahan' => 'required',
            'satuan' => 'required',
        ]);
        DB::transaction(function () use ($data) {
            $manufacturingOrder = ManufacturingOrder::create([
                'kode_order' => ManufacturingOrder::setKodeOrder(),
                'id_produk' => $data['id_produk'],
                'id_bom' => $data['id_bom'],
                'jumlah_order' => $data['jumlah_order'],
                'status' => 'Draft',
            ]);

            foreach ($data['id_bahan'] as $key => $value) {
                ManufacturingOrderDetail::create([
                    'id_manufacturing_order' => $manufacturingOrder->id,
                    'id_bahan' => $value,
                    'jumlah' => $data['jumlah_bahan'][$key],
                    'satuan' => $data['satuan'][$key],
                ]);
            }
        });

        $manufacturingOrderId = ManufacturingOrder::latest()->first()->id;


        return redirect()->route('dashboard.manufacturing-orders.show', $manufacturingOrderId)->with('success', 'Manufacturing Order berhasil ditambahkan');
    }

    public function show(ManufacturingOrder $manufacturingOrder)
    {
        return view('pages.manufacturing-order.show', [
            'manufacturingOrder' => $manufacturingOrder,
        ]);
    }

    public function getBomDetail($jumlah, $id): \Illuminate\Http\JsonResponse
    {
        $bom = Bom::find($id);
        $bomDetail = $bom->bomDetail;

        $data = [];
        $bomDetails = [];

        foreach ($bomDetail as $item) {
            $jumlahBahan = $item->jumlah * $jumlah;
            $satuan = $item->satuan;
            if ($item->satuan == 'gram') {
                $jumlahBahan = $jumlahBahan / 1000;
                $satuan = 'kg';
            } else if ($item->satuan == 'ml') {
                $jumlahBahan = $jumlahBahan / 1000;
                $satuan = 'liter';
            }
            $bomDetails[] = [
                'id_bom' => $item->id_bom,
                'id_bahan' => $item->id_bahan,
                'nama_bahan' => $item->material->nama_bahan,
                'jumlah' => $jumlahBahan,
                'satuan' => $satuan,
            ];
        }

        $data = [
            'id_bom' => $bom->id,
            'kode_bom' => $bom->kode_bom,
            'produk' => $bom->product->nama_produk ?? 'Tidak ada produk',
            'bomDetail' => $bomDetails,
        ];

        return response()->json($data);
    }

    public function confirm(ManufacturingOrder $manufacturingOrder)
    {
        if(!$manufacturingOrder) {
            abort(404);
        }
        $manufacturingOrder->update([
            'status' => 'Confirmed',
        ]);

        return redirect()->route('dashboard.manufacturing-orders.show', $manufacturingOrder)->with('success', 'Manufacturing Order berhasil dikonfirmasi');
    }

    public function progress(ManufacturingOrder $manufacturingOrder)
    {
        if(!$manufacturingOrder) {
            abort(404);
        }
        $manufacturingOrder->update([
            'status' => 'In-Progress',
        ]);

        return redirect()->route('dashboard.manufacturing-orders.show', $manufacturingOrder)->with('success', 'Manufacturing Order akan diproses');
    }

    public function done(ManufacturingOrder $manufacturingOrder)
    {
        
        $product = Product::find($manufacturingOrder->id_produk);
        
        if(!$manufacturingOrder || !$product) {
            abort(404);
        }

        foreach ($manufacturingOrder->manufacturingOrderDetails as $item) {
            $material = Material::find($item->id_bahan);
            $material->update([
                'jumlah' => $material->jumlah - $item->jumlah,
            ]);
        }

        $product->update([
            'jumlah' => $product->jumlah + $manufacturingOrder->jumlah_order,
        ]);


        $manufacturingOrder->update([
            'status' => 'Done',
        ]);

        return redirect()->route('dashboard.manufacturing-orders.show', $manufacturingOrder)->with('success', 'Manufacturing Order berhasil dikonfirmasi');
    }
}
