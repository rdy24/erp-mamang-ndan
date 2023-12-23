@extends('layouts.app')

@section('title')
Dashboard | {{ config('app.name') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Vendor</h1>
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
            <a href="{{ route('dashboard.vendors.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Vendor
            </a>
            <a href="{{ route('dashboard.vendors.create') }}" class="btn btn-primary">
                <img src="{{ asset('assets/img/vuesax/bold/document-download.png') }}" alt="icon download"
                    style="height: 25px">
            </a>
        </div>
    </div>
    @forelse ($vendors as $vendor)
    <div class="card px-2 py-3">
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $vendor->gambar ? asset('uploads/vendor/' . $vendor->gambar) : asset('assets/img/blank-image.png') }}"
                    alt="" style="width: 250px; object-fit: cover; object-position: center;">
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-sm">
                            <tr style="white-space: nowrap">
                                <td width="30px">Kode Vendor</td>
                                <td width="10px">:</td>
                                <td>{{ $vendor->kode_vendor }}</td>
                            </tr>
                            <tr style="white-space: nowrap">
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $vendor->name }}</td>
                            </tr>
                            @if ($vendor->type == 'individual')
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $vendor->position }} di {{ $vendor->company_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $vendor->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{ $vendor->phone }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $vendor->address }}</td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td>{{ $vendor->type }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.vendors.edit', $vendor->id) }}" class="btn btn-warning">Edit</a>
                        <a href="" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">
        Tidak ada vendor
    </div>
    @endforelse

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</section>
@endsection