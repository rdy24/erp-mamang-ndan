@extends('layouts.app')

@section('title')
Tambah RFQ | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/select2/dist/css/select2.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/selectric/public/selectric.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/bootstrap-tagsinput/dist/bootstrap-tagsinput.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>Tambah RFQ</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Tambah RFQ</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.purchase.rfq.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="vendor_id">Vendor</label>
                            <select name="vendor_id" required class="form-control select2">
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id')==$vendor->id ? 'selected' : ''
                                    }}>
                                    {{ $vendor->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_bahan">Bahan Baku</label>
                            <div id="bahan-baku-container">
                                <div class="row form-bahan-baku mb-2">
                                    <div class="col-md-3">
                                        <select name="id_bahan[]" required class="form-control bahan-baku-select">
                                            <option value="">Pilih Bahan Baku</option>
                                            @foreach($materials as $material)
                                            <option value="{{ $material->id }}" {{ old('id_bahan[]')==$material->id ?
                                                'selected' :
                                                ''
                                                }} data-price="{{ $material->harga }}" data-satuan="{{ $material->satuan
                                                }}">
                                                {{ $material->nama_bahan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control jumlah-input" name="jumlah[]" required
                                            value="{{ old('jumlah[]') }}" placeholder="jumlah">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control satuan-input" name="satuan[]" required
                                            value="{{ old('satuan[]') }}" placeholder="satuan" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control harga-input" name="harga[]" required
                                            value="{{ old('harga[]') }}" placeholder="harga" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control total-harga-input" name="total_harga[]"
                                            required value="{{ old('total_harga[]') }}" placeholder="Total Harga"
                                            readonly>
                                    </div>

                                </div>
                                <div id="button-add-remove">
                                    <button type="button" class="btn btn-primary" id="add-row"><i
                                            class="fas fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger" id="remove-row"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>
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

@push('js-libraries')
<script src={{ asset("assets/module/select2/dist/js/select2.full.min.js") }}></script>
<script src={{ asset("assets/module/selectric/public/jquery.selectric.min.js") }}></script>
<script src={{ asset("assets/module/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js") }}></script>
@endpush

@push('js-page')
<script>
    document.addEventListener('click', function (e) {
        if (e.target && e.target.id === 'add-row') {
            var newRow = document.querySelector('.row.form-bahan-baku').cloneNode(true);
            var container = document.getElementById('bahan-baku-container');
            var buttonDiv = document.getElementById('button-add-remove');
            newRow.querySelectorAll('input').forEach(function (input) {
                input.value = '';
            });
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

    $(document).on('change', '.bahan-baku-select', function () {
        var price = $(this).find(':selected').data('price');
        var satuan = $(this).find(':selected').data('satuan');
        $(this).closest('.row.form-bahan-baku').find('.harga-input').val(price);
        $(this).closest('.row.form-bahan-baku').find('.satuan-input').val(satuan);
    });

    $(document).on('keyup', '.jumlah-input', function () {
        updateTotalHarga($(this).closest('.row.form-bahan-baku'));
    });

    function updateTotalHarga(row) {
        var jumlah = parseFloat(row.find('.jumlah-input').val()) || 0;
        var harga = parseFloat(row.find('.harga-input').val()) || 0;
        var totalHarga = jumlah * harga;
        row.find('.total-harga-input').val(totalHarga);
    }
</script>
@endpush
