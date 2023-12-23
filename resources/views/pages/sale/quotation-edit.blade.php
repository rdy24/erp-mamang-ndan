@extends('layouts.app')

@section('title')
Edit Quotation | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/bootstrap-daterangepicker/daterangepicker.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/select2/dist/css/select2.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/selectric/public/selectric.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/bootstrap-tagsinput/dist/bootstrap-tagsinput.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>Edit Quotation</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Edit Quotation</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.sale.quotation.update', $sale->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="customer_id">Customer</label>
                            <select name="customer_id" required class="form-control select2">
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $sale->customer_id)==$customer->id ? 'selected' :
                                    ''
                                    }}>
                                    {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quotation_template_id">Quotation Template</label>
                            <select name="quotation_template_id" class="form-control select2" id="quotation_template">
                                <option value="">Pilih Template</option>
                                @foreach($templates as $template)
                                <option value="{{ $template->id }}" {{ old('quotation_template_id', $sale->quotation_template_id)==$template->id ?
                                    'selected' :
                                    ''
                                    }}>
                                    {{ $template->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expired_date">Tanggal Kadaluarsa</label>
                            <input type="text" name="expired_date" id="expired_date" class="form-control datepicker" value="{{ old('expired_date', $sale->expired_date) }}">
                        </div>
                        <div class="form-group">
                            <label for="id_produk">Produk</label>
                            <div id="bahan-baku-container">
                                @foreach ($sale->sale_details as $item)
                                    <div class="row form-bahan-baku mb-2">
                                        <div class="col-md-3">
                                            <select name="id_produk[]" required class="form-control bahan-baku-select">
                                                <option value="">Pilih Produk</option>
                                                @foreach($products as $product)
                                                <option value="{{ $product->id }}" {{ old('id_produk[]', $item->product_id)==$product->id ?
                                                    'selected' :
                                                    ''
                                                    }} data-price="{{ $product->harga }}" data-satuan="{{ $product->satuan
                                                    }}">
                                                    {{ $product->nama_produk }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control jumlah-input" name="jumlah[]" required
                                                value="{{ old('jumlah[]', $item->qty) }}" placeholder="jumlah">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control harga-input" name="harga[]" required
                                                value="{{ old('harga[]', $item->product->harga) }}" placeholder="harga">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control total-harga-input" name="total_harga[]" required
                                                value="{{ old('total_harga[]', $item->harga) }}" placeholder="total harga">
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
<script src={{ asset("assets/module/bootstrap-daterangepicker/daterangepicker.js") }}></script>
@endpush

@push('js-page')
<script>
    $(document).ready(function () {
        // Add an event listener to the quotation_template select element
        $('#quotation_template').on('change', function () {
            var templateId = $(this).val();

            // Make an AJAX request
            $.ajax({
                type: 'GET',
                url: '/get-template/' + templateId,
                data: { template_id: templateId },
                success: function (data) {
                    // Handle the response data, for example, update other elements on the page
                    console.log(data);
                    // Set the values based on the returned data
                    var currentDate = new Date();
                    var expiredDate = new Date(currentDate);
                    expiredDate.setDate(currentDate.getDate() + data.expired);
                    
                    // Format the expired date as needed
                    var formattedExpiredDate = expiredDate.toISOString().split('T')[0];
                    
                    $('#expired_date').val(formattedExpiredDate);

                    var templateRow = $('.row.form-bahan-baku').first().clone();
                    $('#bahan-baku-container .row.form-bahan-baku').remove();

                    // Loop through template_details and populate the fields
                    for (var i = 0; i < data.template_details.length; i++) {
                        var templateDetail = data.template_details[i];
                        var newRow = templateRow.clone();
                        
                        // Set values for the new row based on template_detail
                        $(newRow).find('.bahan-baku-select').val(templateDetail.product_id).trigger('change');
                        $(newRow).find('.jumlah-input').val(templateDetail.qty);
                        // You may need to fetch the data-price attribute from the selected option
                        var price = $(newRow).find('.bahan-baku-select option:selected').data('price');
                        $(newRow).find('.harga-input').val(price);
                        // Calculate and set the total harga
                        var totalHarga = templateDetail.qty * price;
                        $(newRow).find('.total-harga-input').val(totalHarga);

                        // Append the new row to the container and in above the button div
                        $('#button-add-remove').before(newRow);
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
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
        $(this).closest('.row.form-bahan-baku').find('.harga-input').val(price);
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