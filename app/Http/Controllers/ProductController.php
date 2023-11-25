<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function show(Product $product)
    {
        $title = 'Hapus Produk';
        $text = "Apakah anda yakin ingin menghapus produk ini?";
        confirmDelete($title, $text);
        return view('pages.products.show', [
            'product' => $product,
        ]);
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(ProductRequest $request)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/product'), $namaFile);
        } else {
            $namaFile = null;
        }

        // insert data ke database
        Product::create([
            'kode_produk' => Product::setKodeProduct(),
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'jumlah' => 0,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFile,
        ]);

        // redirect ke halaman products
        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        return view('pages.products.edit', [
            'product' => $product,
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/product'), $namaFile);

            if ($product->gambar) {
                Storage::delete('public/uploads/product' . $product->gambar);
            }
        } else {
            $namaFile = $product->gambar;
        }

        $product->update([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFile,
        ]);

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil diubah');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil dihapus');
    }
}
