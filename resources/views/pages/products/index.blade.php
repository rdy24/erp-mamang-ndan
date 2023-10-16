@extends('layouts.app')

@section('title')
Dashboard | {{ config('app.name') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Produk</h1>
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
            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
                <img src="{{ asset('assets/img/vuesax/bold/document-download.png') }}" alt="icon download"
                    style="height: 25px">
            </a>
        </div>
    </div>
    @forelse ($products as $product)
    <div class="card px-2 py-3">
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $product->gambar ? asset('uploads/product/' . $product->gambar) : asset('assets/img/blank-image.png') }}"
                    alt="" style="width: 250px; object-fit: cover; object-position: center;">
            </div>
            <div class="col-md-9">
                <table class="table table-sm">
                    <tr style="white-space: nowrap">
                        <td width="30px">Kode Produk</td>
                        <td width="10px">:</td>
                        <td>{{ $product->kode_produk }}</td>
                    </tr>
                    <tr style="white-space: nowrap">
                        <td>Nama Produk</td>
                        <td>:</td>
                        <td>{{ $product->nama_produk }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>{{ $product->jumlah }}</td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>:</td>
                        <td>Rp. {{ number_format($product->harga) }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>:</td>
                        <td>{{ $product->deskripsi }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">
        Tidak ada produk
    </div>
    @endforelse

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</section>
@endsection