@extends('layouts.app')

@section('title')
Sale | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/bootstrap-daterangepicker/daterangepicker.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/bootstrap/css/bootstrap.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/prism/prism.css") }}>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $sale->kode_sales }}</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('dashboard.sale.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if ($sale->status == 'Quotation')
            <a href="{{ route('dashboard.sale.quotation.confirm', $sale->id) }}" class="btn btn-info">
                <i class="fas fa-check"></i> Confirm Order
            </a>
            @endif
            @if ($sale->status == 'Sales Order')
            <a href="{{ route('dashboard.sale.send-quotation', $sale->id) }}" class="btn btn-dark"> Send Quotation By
                Email
            </a>
            <a href="{{ route('dashboard.sale.quotation.create.invoice', $sale->id) }}" class="btn btn-info">
                <i class="fas fa-check"></i> Create Invoice
            </a>
            @endif
        </div>
        <div>
            @if ($sale->status == 'Quotation')
            <a href="{{ route('dashboard.manufacturing-orders.edit', $sale->id) }}" class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('dashboard.manufacturing-orders.destroy', $sale->id) }}" class="btn btn-danger"
                data-confirm-delete="true">
                <i class="fas fa-trash"></i> Hapus
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <table class="table table-sm">
                        <tr style="white-space: nowrap">
                            <td width="30px">Customer</td>
                            <td width="10px">:</td>
                            <td>{{ $sale->customer->name ?? '-' }}</td>
                        </tr>
                        <tr style="white-space: nowrap">
                            <td width="30px">Status</td>
                            <td width="10px">:</td>
                            <td>{{ $sale->status }}</td>
                        </tr>
                        <tr style="white-space: nowrap">
                            <td width="30px">Order Date</td>
                            <td width="10px">:</td>
                            <td>{{ $sale->created_at->format('d-m-y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Bahan Baku</th>
                    <th>Jumlah Bahan</th>
                    <th>Harga Per Unit</th>
                    <th>Total Harga</th>
                </tr>
                @foreach ($sale->sale_details as $item)
                <tr>
                    <td>{{ $item->product->nama_produk }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp. {{ number_format($item->product->harga) }}</td>
                    <td>Rp. {{ number_format($item->harga) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">Total Harga</th>
                    <th>Rp. {{ number_format($sale->total) }}</th>
                </tr>
            </table>
        </div>
    </div>
</section>
@endsection

@push('js-libraries')
<script src={{ asset("assets/module/popper.js") }}></script>
<script src={{ asset("assets/module/tooltip.js") }}></script>
<script src={{ asset("assets/js/stisla.js") }}></script>
<script src={{ asset("assets/module/prism/prism.js") }}></script>
<script src={{ asset('assets/module/bootstrap/js/bootstrap.min.js') }}></script>
<script src={{ asset("assets/module/bootstrap-daterangepicker/daterangepicker.js") }}></script>
<script src={{ asset('assets/js/page/bootstrap-modal.js') }}></script>

<script>
    $('#modalButton').on('click', function () {
        $('#exampleModal').appendTo("body").modal('show');
    });

    // if change type to transfer
    $('#type').on('change', function () {
        if ($(this).val() == 'Transfer') {
            $('#transfer-bank').show();
        } else {
            $('#transfer-bank').hide();
        }
    });
</script>
@endpush