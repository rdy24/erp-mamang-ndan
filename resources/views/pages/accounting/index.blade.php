@extends('layouts.app')

@section('title')
Accounting | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/datatables.net-bs4/css/dataTables.bootstrap4.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/datatables.net-select-bs4/css/select.bootstrap4.min.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>Accounting</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard.') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Accounting</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="">
                    <div class="col-md-3">
                        <div class="input-group">
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Pilih Status --</option>
                                <option value="Debit" {{ request()->status == 'Debit' ? 'selected' : '' }}>Debit</option>
                                <option value="Kredit" {{ request()->status == 'Kredit' ? 'selected' : '' }}>Kredit</option>
                            </select>
                            <div class="input-group-btn mx-4">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            @if (request()->status == 'Debit')
                            <h6>Pemasukan : {{ $total }}</h6>
                            @elseif (request()->status == 'Kredit')
                            <h6>Pengeluaran : {{ $total }}</h6>
                            @else
                            <h6>Pemasukan : {{ $debit }}</h6>
                            <h6>Pengeluaran : {{ $kredit }}</h6>
                            <h6>{{ $keterangan }}</h6>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('dashboard.accounting.print') }}" class="btn btn-primary">Print</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kode Pembayaran</th>
                                    <th>Kode Invoice / Bill</th>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accountings as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                                    <td>{{ $item->payment->kode_payment }}</td>
                                    @if (request()->status == 'Debit')
                                    <td>{{ $item->payment->invoice->kode_invoice }}</td>
                                    @elseif (request()->status == 'Kredit')
                                    <td>{{ $item->payment->bill->kode_bill }}</td>
                                    @else
                                    <td>
                                        {{ $item->payment->bill->kode_bill ?? $item->payment->invoice->kode_invoice }}
                                    </td>
                                    @endif
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js-libraries')
<script src={{ asset("assets/module/datatables/media/js/jquery.dataTables.min.js") }}></script>
<script src={{ asset("assets/module/datatables.net-bs4/js/dataTables.bootstrap4.min.js") }}></script>
<script src={{ asset("assets/module/datatables.net-select-bs4/js/select.bootstrap4.min.js") }}></script>
<script src={{ asset("assets/module/sweetalert/dist/sweetalert.min.js") }}></script>
@endpush

@push('js-page')
<script src={{ asset("assets/js/page/modules-datatables.js") }}></script>
@endpush