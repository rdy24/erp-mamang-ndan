@extends('layouts.app')

@section('title')
Tambah Produk | {{ config('app.name') }}
@endsection

@section('content')
<div class="section-header">
    <h1>Tambah Produk</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Tambah Produk</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="kode_produk">Kode Produk</label>
                            <input type="text" class="form-control" id="kode_produk" name="kode_produk" required
                                value="{{ old('kode_produk') }}">
                            @error('kode_produk')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required
                                value="{{ old('nama_produk') }}">
                            @error('nama_produk')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Produk</label>
                            <input type="text" class="form-control" id="harga" name="harga" required
                                value="{{ old('harga') }}">
                            @error('harga')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Produk</label>
                            <textarea class="form-control" name="deskripsi"
                                id="deskripsi">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="form-label">Foto Produk</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5 d-block">
                            <input class="form-control-file" type="file" id="gambar" name="gambar"
                                onchange="previewImage()">
                            @error('gambar')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-primary">Batal</a>
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