@extends('layouts.app')

@section('title')
Edit Produk | {{ config('app.name') }}
@endsection

@section('content')
<div class="section-header">
    <h1>Edit Produk</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Edit Produk</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="kode_produk">Kode Produk</label>
                            <input type="text" class="form-control" id="kode_produk" name="kode_produk" required
                                value="{{ old('kode_produk', $product->kode_produk) }}">
                            @error('kode_produk')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required
                                value="{{ old('nama_produk', $product->nama_produk) }}">
                            @error('nama_produk')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Produk</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah" required
                                value="{{ old('jumlah', $product->jumlah) }}">
                            @error('jumlah')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Produk</label>
                            <input type="text" class="form-control" id="harga" name="harga" required
                                value="{{ old('harga', $product->harga) }}">
                            @error('harga')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Produk</label>
                            <textarea class="form-control" name="deskripsi"
                                id="deskripsi">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                            @error('deskripsi')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="form-label">Foto Produk</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5 d-block"
                                src="{{ $product->gambar ? asset('uploads/product/' . $product->gambar) : '' }}">
                            <input class="form-control-file" type="file" id="gambar" name="gambar"
                                onchange="previewImage()">
                            @error('gambar')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <a href="{{ route('dashboard.products') }}" class="btn btn-outline-primary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js-page')
<script src={{ asset("assets/js/page/forms-advanced-forms.js") }}></script>
<script>
    function previewImage() {
      const gambar = document.querySelector('#gambar');
      const imgPreview = document.querySelector('.img-preview');
      const blob = URL.createObjectURL(gambar.files[0]);
      imgPreview.src = blob;
    }
</script>
@endpush