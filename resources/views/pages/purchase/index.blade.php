@extends('layouts.app')

@section('title')
{{ $title }} | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/datatables.net-bs4/css/dataTables.bootstrap4.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/datatables.net-select-bs4/css/select.bootstrap4.min.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard.') }}">Dashboard</a></div>
        <div class="breadcrumb-item">{{ $title }}</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    @if (!$isPurchaseOrder)
                    <a href="{{ route('dashboard.purchase.rfq.create') }}" class="btn btn-primary"><i
                            class="fas fa-plus" aria-hidden="true"></i>
                        Tambah Data</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Vendor</th>
                                    <th>Total Harga</th>
                                    <th>{{ $isPurchaseOrder ? 'Bill Status' : 'Status' }}</th>
                                    @if ($isPurchaseOrder)
                                    <th>Tanggal Konfirmasi</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode_purchase }}</td>
                                    <td>{{ $item->vendor->name ?? '-' }}</td>
                                    <td>Rp. {{ number_format($item->total_harga) }}</td>
                                    <td>{{ $isPurchaseOrder ? $item->bill_status : $item->status }}</td>
                                    @if ($isPurchaseOrder)
                                    <td>{{ $item->confirm_date ? $item->confirm_date->format('d M Y') : '-' }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route($isPurchaseOrder ? 'dashboard.purchase-order.show' : 'dashboard.purchase.rfq.show', $item->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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