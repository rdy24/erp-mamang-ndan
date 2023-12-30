@extends('layouts.app')

@section('title')
Purchase | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/bootstrap-daterangepicker/daterangepicker.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/bootstrap/css/bootstrap.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/prism/prism.css") }}>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $purchase->kode_purchase }}</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route($isPurchaseOrder ? 'dashboard.purchase-order.index' : 'dashboard.purchase.rfq') }}"
                class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if ($purchase->status == 'RFQ')
            <a href="{{ route('dashboard.purchase.rfq.send', $purchase->id) }}" class="btn btn-dark"> Send RFQ By Email
            </a>
            <a href="{{ route('dashboard.purchase.rfq.print', $purchase->id) }}" class="btn btn-info">
                Print RFQ
            </a>
            <a href="{{ route('dashboard.purchase.rfq.confirm', $purchase->id) }}" class="btn btn-success">
                <i class="fas fa-check"></i> Confirm Order
            </a>
            @endif
            @if ($purchase->status == 'Purchase Order')
            <a href="{{ route('dashboard.purchase-order.send', $purchase->id) }}" class="btn btn-dark"> Send Purchase Order By Email
            </a>
            <a href="{{ route('dashboard.purchase-order.print', $purchase->id) }}" class="btn btn-info">
                Print Purchase Order
            </a>
            @endif
            @if ($purchase->status == 'Purchase Order' && $purchase->bill_status == 'Nothing to Bill' &&
            $purchase->receive_status == 'Waiting')
            <a href="{{ route('dashboard.purchase-order.receive', $purchase->id) }}" class="btn btn-dark">
                <i class="fas fa-procedures"></i> Receive Products
            </a>
            @endif
            @if ($purchase->status == 'Purchase Order' && $purchase->bill_status == 'Nothing to Bill' &&
            $purchase->receive_status == 'Ready')
            <a href="{{ route('dashboard.purchase-order.validate', $purchase->id) }}" class="btn btn-dark">
                <i class="fas fa-procedures"></i> Validate
            </a>
            @endif
            @if ($purchase->status == 'Purchase Order' && $purchase->bill_status == 'Waiting Bills' && !$bill)
            <a href="{{ route('dashboard.purchase-order.bill.create', $purchase->id) }}" class="btn btn-success">
                <i class="fas fa-check-square"></i> Create Bill
            </a>
            @endif
            @if ($purchase->status == 'Purchase Order' && $purchase->bill_status == 'Waiting Bills' && $bill?->status ==
            'Draft')
            <a href="{{ route('dashboard.purchase-order.bill.post', $purchase->id) }}" class="btn btn-success">
                <i class="fas fa-check-square"></i> Post
            </a>
            @endif
            @if ($purchase->status == 'Purchase Order' && $purchase->bill_status == 'Waiting Bills' && $bill?->status ==
            'Posted')
            <button type="button" class="btn btn-info" id="modalButton">
                Register Payment
            </button>
            @endif
        </div>
        <div>
            @if ($purchase->status == 'RFQ')
            <a href="{{ route('dashboard.purchase.rfq.edit', $purchase->id) }}" class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('dashboard.purchase.rfq.destroy', $purchase->id) }}" class="btn btn-danger"
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
                            <td width="30px">Vendor</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->vendor->name ?? '-' }}</td>
                        </tr>
                        @if ($purchase->status == 'RFQ')
                        <tr style="white-space: nowrap">
                            <td width="30px">Tanggal Order</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->order_date ?? '-' }}</td>
                        </tr>
                        @endif
                        @if ($purchase->confirm_date)
                        <tr style="white-space: nowrap">
                            <td width="30px">Tanggal Konfirmasi</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->confirm_date }}</td>
                        </tr>
                        @endif
                        @if ($purchase->receive_date)
                        <tr style="white-space: nowrap">
                            <td width="30px">Tanggal Barang Diterima</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->receive_date }}</td>
                        </tr>
                        @endif
                        <tr style="white-space: nowrap">
                            <td width="30px">Status</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->status }}</td>
                        </tr>
                        <tr style="white-space: nowrap">
                            <td width="30px">Status Pembayaran</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->bill_status ?? '-' }}</td>
                        </tr>
                        <tr style="white-space: nowrap">
                            <td width="30px">Status Barang</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->receive_status ?? '-' }}</td>
                        </tr>
                        <tr style="white-space: nowrap">
                            <td width="30px">Status Bill</td>
                            <td width="10px">:</td>
                            <td>{{ $purchase->bill->status ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                @if ($purchase->status == 'Purchase Order' && $purchase->bill_status == 'Waiting Bills' &&
                $bill?->status
                == 'New')
                <div class="col-md-2">
                    <form action="{{ route('dashboard.purchase-order.bill.store', $purchase->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="bill_date">Bill Date</label>
                            <input type="text" class="form-control datepicker" id="bill_date" name="bill_date" required
                                value="{{ old('bill_date') }}">
                            @error('bill_date')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="accounting_date">Accounting Date</label>
                            <input type="text" class="form-control datepicker" id="accounting_date"
                                name="accounting_date" required value="{{ old('accounting_date') }}">
                            @error('accounting_date')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save Bill</button>
                    </form>
                </div>
                @endif
                @if ($purchase->status == 'Purchase Order' && $purchase->bill_status == 'Waiting Bills' &&
                $bill?->status == 'Draft')
                <div class="col-md-2">
                    <table class="table table-sm">
                        <tr style="white-space: nowrap">
                            <td width="30px">Bill Date</td>
                            <td width="10px">:</td>
                            <td>{{ $bill->bill_date ? $bill->bill_date->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr style="white-space: nowrap">
                            <td width="30px">Accounting Date</td>
                            <td width="10px">:</td>
                            <td>{{ $bill->accounting_date ? $bill->accounting_date->format('d M Y') : '-' }}</td>
                        </tr>
                    </table>
                </div>
                @endif
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
                @foreach ($purchase->purchaseDetails as $item)
                <tr>
                    <td>{{ $item->material->nama_bahan }}</td>
                    <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                    <td>Rp. {{ number_format($item->material->harga) }}</td>
                    <td>Rp. {{ number_format($item->total_harga) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">Total Harga</th>
                    <th>Rp. {{ number_format($purchase->total) }}</th>
                </tr>
            </table>
        </div>
    </div>
</section>

<!-- Modal -->
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
                <form action="{{ route('dashboard.purchase-order.payment.store', $purchase->id) }}" method="POST">
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
                                    <input type="text" name="amount" id="amount" class="form-control" value="{{ $purchase->total }}">
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