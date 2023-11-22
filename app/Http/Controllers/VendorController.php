<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        if (request()->has('search')) {
            $vendors = Vendor::where('name', 'like', "%" . request('search') . "%")
                        ->paginate(5);
        } else {
            $vendors = Vendor::paginate(5);
        } 

        return view('pages.vendors.index', [
            'vendors' => $vendors,
        ]);
    }

    public function show(Vendor $vendor)
    {
        $title = 'Hapus Vendor';
        $text = "Apakah anda yakin ingin menghapus vendor ini?";
        confirmDelete($title, $text);
        return view('pages.vendors.show', [
            'vendor' => $vendor,
        ]);
    }

    public function create()
    {
        return view('pages.vendors.create');
    }

    public function store(Request $request)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/product'), $namaFile);
        } else {
            $namaFile = null;
        }

        // insert data ke database
        Vendor::create([
            'kode_vendor' => Vendor::setKodeVendor(),
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type,
            'foto' => $namaFile,
        ]);

        // redirect ke halaman products
        return redirect()->route('dashboard.vendors.index')->with('success', 'Vendor berhasil ditambahkan');
    }
}
