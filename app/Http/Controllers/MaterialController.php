<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $title = 'Hapus Bahan Baku';
        $text = "Apakah anda yakin ingin menghapus bahan baku ini?";
        confirmDelete($title, $text);
        $materials = Material::all();
        return view('pages.materials.index' , [
            'materials' => $materials,
        ]);
    }

    public function create()
    {
        return view('pages.materials.create');
    }

    public function store(MaterialRequest $request)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/material'), $namaFile);
        } else {
            $namaFile = null;
        }

        // insert data ke database
        Material::create([
            'kode_bahan' => Material::setKodeMaterial(),
            'nama_bahan' => $request->nama_bahan,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'jumlah' => 0,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFile,
        ]);

        // redirect ke halaman products
        return redirect()->route('dashboard.materials.index')->with('success', 'Bahan berhasil ditambahkan');
    }

    public function edit(Material $material)
    {
        return view('pages.materials.edit', [
            'material' => $material,
        ]);
    }

    public function update(MaterialRequest $request, Material $material)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/material'), $namaFile);

            if ($material->gambar) {
                Storage::delete('public/uploads/material' . $material->gambar);
            }
        } else {
            $namaFile = $material->gambar;
        }

        // update data ke database
        $material->update([
            'nama_bahan' => $request->nama_bahan,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'jumlah' => 0,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFile,
        ]);

        // redirect ke halaman products
        return redirect()->route('dashboard.materials.index')->with('success', 'Bahan berhasil diupdate');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('dashboard.materials.index')->with('success', 'Bahan berhasil dihapus');
    }

    public function print()
    {
        $materials = Material::all();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.materials.print', ['materials' => $materials]);

        return $pdf->stream('materials.pdf');
    }
}
