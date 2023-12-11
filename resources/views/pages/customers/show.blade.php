@extends('layouts.app')

@section('title')
Dashboard | {{ config('app.name') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $product->nama_produk }}</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div>
            <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('dashboard.products.destroy', $product->id) }}" class="btn btn-danger"
                data-confirm-delete="true">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </div>
    </div>

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
</section>
@endsection