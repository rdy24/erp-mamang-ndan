@extends('layouts.app')

@section('title')
Dashboard | {{ config('app.name') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Customer</h1>
    </div>
    <div class="row mb-3">
        <div class="col-md-9">
            <form action="" class="d-flex">
                <input type="text" class="form-control" placeholder="search here" name="search"
                    value="{{ request()->search }}">
                <button class="btn btn-primary ml-2">Search</button>
            </form>
        </div>
        <div class="col-md-3">
            <a href="{{ route('dashboard.customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Customer
            </a>
            <a href="{{ route('dashboard.customers.create') }}" class="btn btn-primary">
                <img src="{{ asset('assets/img/vuesax/bold/document-download.png') }}" alt="icon download"
                    style="height: 25px">
            </a>
        </div>
    </div>
    @forelse ($customers as $customer)
    <div class="card px-2 py-3">
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $customer->foto ? asset('uploads/customer/' . $customer->foto) : asset('assets/img/blank-image.png') }}"
                    alt="" style="width: 250px; object-fit: cover; object-position: center;">
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-sm">
                            <tr style="white-space: nowrap">
                                <td width="30px">Kode customer</td>
                                <td width="10px">:</td>
                                <td>{{ $customer->kode_customer }}</td>
                            </tr>
                            <tr style="white-space: nowrap">
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            @if ($customer->type == 'individual')
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $customer->position }} di {{ $customer->company_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $customer->address }}</td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td>{{ $customer->type }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('dashboard.customers.destroy', $customer->id) }}" class="btn btn-danger" data-confirm-delete="true">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">
        Tidak ada customer
    </div>
    @endforelse

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</section>
@endsection