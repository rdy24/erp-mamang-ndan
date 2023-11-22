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
                    <form action="{{ route('dashboard.vendors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name') }}">
                            @error('name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="{{ old('email') }}">
                            @error('email')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">phone</label>
                            <input type="phone" class="form-control" id="phone" name="phone" required
                                value="{{ old('phone') }}">
                            @error('phone')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">Tipe</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type" value="individual" {{
                                    old('type')=='individual' ? 'checked' : '' }}>
                                <label class="form-check-label" for="type">
                                    Individual
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type1" value="company" {{
                                    old('type')=='company' ? 'checked' : '' }}>
                                <label class="form-check-label" for="type1">
                                    Company
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="form-label">Foto</label>
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
                        <a href="{{ route('dashboard.vendors.index') }}" class="btn btn-outline-primary">Batal</a>
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