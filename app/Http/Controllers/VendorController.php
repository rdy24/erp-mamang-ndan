<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function index()
    {
        $title = 'Hapus Vendor';
        $text = "Apakah anda yakin ingin menghapus vendor ini?";
        confirmDelete($title, $text);
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
        return view('pages.vendors.show', [
            'vendor' => $vendor,
        ]);
    }

    public function create()
    {
        $vendors = Vendor::where('type', 'company')->get();
        return view('pages.vendors.create', [
            'vendors' => $vendors,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/vendor'), $namaFile);
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
            'position' => $request->position,
            'company_name' => $request->company_name,
            'foto' => $namaFile,
        ]);

        // redirect ke halaman products
        return redirect()->route('dashboard.vendors.index')->with('success', 'Vendor berhasil ditambahkan');
    }

    public function edit(Vendor $vendor)
    {
        $vendors = Vendor::where('type', 'company')->get();
        return view('pages.vendors.edit', [
            'vendor' => $vendor,
            'vendors' => $vendors,
        ]);
    }

    public function update(Request $request, Vendor $vendor)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/vendor'), $namaFile);

            if ($vendor->gambar) {
                Storage::delete('public/uploads/vendor' . $vendor->gambar);
            }
        } else {
            $namaFile = $vendor->gambar;
        }

        $vendor->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type,
            'position' => $request->position,
            'company_name' => $request->company_name,
            'foto' => $namaFile,
        ]);

        return redirect()->route('dashboard.vendors.index')->with('success', 'Vendor berhasil diupdate');
    }

    public function getVendor($id)
    {
        $vendor = Vendor::find($id);
        return response()->json($vendor);
    }

    public function destroy(Vendor $vendor)
    {
        if ($vendor->foto) {
            Storage::delete('public/uploads/vendor' . $vendor->foto);
        }
        $vendor->delete();

        return redirect()->route('dashboard.vendors.index')->with('success', 'Vendor berhasil dihapus');
    }

    public function print()
    {
        $vendors = Vendor::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.vendors.print', ['vendors' => $vendors]);

        return $pdf->stream('vendors.pdf');
    }
}
