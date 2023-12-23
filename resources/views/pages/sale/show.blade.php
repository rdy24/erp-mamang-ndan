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
            @if ($sale->status == 'Invoice' && $sale->invoice_status == 'Draft')
            <a href="{{ route('dashboard.sale.invoice.confirm', $sale->id) }}" class="btn btn-info">
                <i class="fas fa-check"></i> Confirm Invoice
            </a>
            @endif
            @if ($sale->status == 'Invoice' && $sale->invoice_status == 'Posted')
            <a href="{{ route('dashboard.sale.send-invoice', $sale->id) }}" class="btn btn-dark"> Send Invoice By
                Email
            </a>
            <a href="{{ route('dashboard.sale.print-invoice', $sale->id) }}" class="btn btn-info">
                Print Invoice
            </a>
            @endif
            @if ($sale->status == 'Invoice' && $sale->invoice_status == 'Posted' && !$sale->payment)
            <button type="button" class="btn btn-info" id="modalButton">
                Register Payment
            </button>
            @endif
            @if ($sale?->payment?->status == 'Paid' && !$sale->delivery_status)
            <a href="{{ route('dashboard.sale.deliver-product', $sale->id) }}" class="btn btn-success">
                Deliver Product
            </a>
            @endif
        </div>
        <div>
            @if ($sale->status == 'Quotation')
            <a href="{{ route('dashboard.sale.quotation.edit', $sale->id) }}" class="btn btn-warning">
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
                        @if ($sale->invoice_status)
                        <tr style="white-space: nowrap">
                            <td width="30px">Invoice Status</td>
                            <td width="10px">:</td>
                            <td>{{ $sale->invoice_status }}</td>
                        </tr>
                        @endif
                        @if ($sale?->payment?->status)
                        <tr style="white-space: nowrap">
                            <td width="30px">Payment Status</td>
                            <td width="10px">:</td>
                            <td><span class="badge badge-success">{{ $sale->payment->status }}</span></td>
                        </tr>
                        @endif
                        @if ($sale->delivery_status)
                        <tr style="white-space: nowrap">
                            <td width="30px">Delivery Status</td>
                            <td width="10px">:</td>
                            <td>{{ $sale->delivery_status }}</td>
                        </tr>
                        @endif
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.sale.invoice.payment', $sale->id) }}" method="POST">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="type">Tipe</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer">Transfer</option>
                                    </select>
                                </div>
                                <div id="transfer-bank" style="display: none">
                                    <div class="mb-2">
                                        <label for="bank">Bank</label>
                                        <input type="text" name="bank" id="bank" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label for="account_number">Nomor Rekening</label>
                                        <input type="text" name="account_number" id="account_number"
                                            class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label for="account_name">Nama Rekening</label>
                                        <input type="text" name="account_name" id="account_name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="amount">Jumlah</label>
                                    <input type="text" name="amount" id="amount" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <label for="payment_date">Tanggal</label>
                                    <input type="text" name="payment_date" id="payment_date"
                                        class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Validate</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
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