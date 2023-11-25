@extends('layouts.app')

@section('title')
Edit BOM | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/select2/dist/css/select2.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/selectric/public/selectric.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/bootstrap-tagsinput/dist/bootstrap-tagsinput.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>Edit BOM</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Edit BOM</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.bom.update', $bom->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="id_produk">Produk</label>
                            <select name="id_produk" required class="form-control select2">
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('id_produk', $bom->id_produk)==$product->id ?
                                    'selected' : ''
                                    }}>
                                    {{ $product->nama_produk }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_bahan">Bahan Baku</label>
                            <div id="bahan-baku-container">
                                @foreach ($bom->bomDetail as $item)
                                <div class="row form-bahan-baku mb-2">
                                    <div class="col-md-5">
                                        <select name="id_bahan[]" required class="form-control">
                                            @foreach($materials as $material)
                                            <option value="{{ $material->id }}" {{ old('id_bahan[]', $item->
                                                id_bahan)==$material->id ?
                                                'selected' :
                                                ''
                                                }}>
                                                {{ $material->nama_bahan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="jumlah[]" required
                                            value="{{ old('jumlah[]', $item->jumlah) }}" placeholder="jumlah">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="satuan[]" id="satuan" class="form-control">
                                            <option value="kg" {{ old('satuan[]', $item->satuan)=='kg' ? 'selected'
                                                :''}}>kg</option>
                                            <option value="gram" {{ old('satuan[]', $item->satuan)=='gram' ? 'selected'
                                                :''}}>gram</option>
                                            <option value="liter" {{ old('satuan[]', $item->satuan)=='liter' ?
                                                'selected'
                                                :''}}>liter</option>
                                            <option value="ml" {{ old('satuan[]', $item->satuan)=='ml' ? 'selected'
                                                :''}}>ml</option>
                                            <option value="pcs" {{ old('satuan[]', $item->satuan)=='pcs' ? 'selected'
                                                :''}}>pcs</option>
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                                <div id="button-add-remove">
                                    <button type="button" class="btn btn-primary" id="add-row"><i
                                            class="fas fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger" id="remove-row"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>
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

@push('js-libraries')
<script src={{ asset("assets/module/select2/dist/js/select2.full.min.js") }}></script>
<script src={{ asset("assets/module/selectric/public/jquery.selectric.min.js") }}></script>
<script src={{ asset("assets/module/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js") }}></script>
@endpush

@push('js-page')
<script>
    function previewImage() {
      const gambar = document.querySelector('#gambar');
      const imgPreview = document.querySelector('.img-preview');
      const blob = URL.createObjectURL(gambar.files[0]);
      imgPreview.src = blob;
    }
</script>
<script>
    document.addEventListener('click', function (e) {
        if (e.target && e.target.id === 'add-row') {
            var newRow = document.querySelector('.row.form-bahan-baku').cloneNode(true);
            var container = document.getElementById('bahan-baku-container');
            var buttonDiv = document.getElementById('button-add-remove');
            // $('#bahan-baku-container .select2').select2();
            container.insertBefore(newRow, buttonDiv);
        } else if (e.target && e.target.id === 'remove-row') {
            var container = document.getElementById('bahan-baku-container');
            var rows = container.querySelectorAll('.row.form-bahan-baku');
            if (rows.length > 1) {
                container.removeChild(rows[rows.length - 1]);
            }
            // $('#bahan-baku-container .select2').select2();
        }
    });
</script>
@endpush