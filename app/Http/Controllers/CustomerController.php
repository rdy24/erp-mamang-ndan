<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        if (request()->has('search')) {
            $customers = Customer::where('name', 'like', "%" . request('search') . "%")
                        ->paginate(5);
        } else {
            $customers = Customer::paginate(5);
        }

        $title = 'Hapus Customer';
        $text = "Apakah anda yakin ingin menghapus Customer ini?";
        confirmDelete($title, $text);

        return view('pages.customers.index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        $customer = Customer::where('type', 'company')->get();
        return view('pages.customers.create', [
            'customers' => $customer,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/customer'), $namaFile);
        } else {
            $namaFile = null;
        }

        // insert data ke database
        Customer::create([
            'kode_customer' => Customer::setKodeCustomer(),
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
        return redirect()->route('dashboard.customers.index')->with('success', 'Customer berhasil ditambahkan');
    }

    public function edit(Customer $customer)
    {
        $companyCustomers = Customer::where('type', 'company')->get();
        return view('pages.customers.edit', [
            'customer' => $customer,
            'companyCustomers' => $companyCustomers,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        if ($request->file('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/customer'), $namaFile);

            if ($customer->gambar) {
                Storage::delete('public/uploads/customer' . $customer->gambar);
            }
        } else {
            $namaFile = $customer->gambar;
        }

        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type,
            'position' => $request->position,
            'company_name' => $request->company_name,
            'foto' => $namaFile,
        ]);

        return redirect()->route('dashboard.customers.index')->with('success', 'Customer berhasil diupdate');
    }

    public function getCustomer($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }
    
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('dashboard.customers.index')->with('success', 'Customer berhasil dihapus');
    }

    public function print()
    {
        $customers = Customer::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.customers.print', ['customers' => $customers]);

        return $pdf->stream('customers.pdf');
    }
}
