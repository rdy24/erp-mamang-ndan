@extends('layouts.app')

@section('title')
Edit Bahan Baku | {{ config('app.name') }}
@endsection

@section('content')
<div class="section-header">
    <h1>Edit Bahan Baku {{ $material->nama_bahan }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Edit Bahan Baku</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.materials.update', $material->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="nama_bahan">Nama Bahan Baku</label>
                            <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" required
                                value="{{ old('nama_bahan', $material->nama_bahan) }}">
                            @error('nama_bahan')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Bahan</label>
                            <input type="text" class="form-control" id="harga" name="harga" required
                                value="{{ old('harga', $material->harga) }}">
                            @error('harga')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select name="satuan" id="satuan" class="form-control">
                                <option value="kg" {{ old('satuan', $material->satuan)=='kg' ? 'selected' : '' }}>kg
                                </option>
                                <option value="liter" {{ old('satuan', $material->satuan)=='liter' ? 'selected' : ''
                                    }}>liter</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="form-label">Foto Bahan</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5 d-block"
                                src="{{ $material->gambar ? asset('uploads/material/' . $material->gambar) : '' }}">
                            <input class="form-control-file" type="file" id="gambar" name="gambar"
                                onchange="previewImage()">
                            @error('gambar')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
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