<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // check if has search
        if (request()->has('search')) {
            $products = Product::where('nama_produk', 'like', "%" . request('search') . "%")
                        ->orWhere('kode_produk', 'like', "%" . request('search') . "%")
                        ->paginate(5);
        } else {
            $products = Product::paginate(5);
        } 

        return view('pages.products.index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(ProductRequest $request)
    {
        $gambar = $request->file('gambar');
        $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
        $gambar->move(public_path('uploads/product'), $namaFile);

        // insert data ke database
        Product::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFile,
        ]);

        // redirect ke halaman products
        return redirect()->route('dashboard.products')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('pages.products.edit', [
            'product' => $product,
        ]);
    }
}
