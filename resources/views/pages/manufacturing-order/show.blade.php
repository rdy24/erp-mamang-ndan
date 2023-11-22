@extends('layouts.app')

@section('title')
Dashboard | {{ config('app.name') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $manufacturingOrder->kode_order }}</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('dashboard.manufacturing-orders.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('dashboard.manufacturing-orders.confirm', $manufacturingOrder->id) }}"
                class="btn btn-info">
                <i class="fas fa-check"></i> Confirm
            </a>
            <a href="{{ route('dashboard.manufacturing-orders.progress', $manufacturingOrder->id) }}"
                class="btn btn-dark">
                <i class="fas fa-procedures"></i> On Progress
            </a>
            <a href="{{ route('dashboard.manufacturing-orders.done', $manufacturingOrder->id) }}"
                class="btn btn-success">
                <i class="fas fa-check-square"></i> Done
            </a>
        </div>
        <div>
            <a href="{{ route('dashboard.manufacturing-orders.edit', $manufacturingOrder->id) }}"
                class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('dashboard.manufacturing-orders.destroy', $manufacturingOrder->id) }}"
                class="btn btn-danger" data-confirm-delete="true">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <tr style="white-space: nowrap">
                    <td width="30px">BOM</td>
                    <td width="10px">:</td>
                    <td>{{ $manufacturingOrder->bom->kode_bom ?? '-' }} - {{
                        $manufacturingOrder->bom->product->nama_produk ?? '-' }}</td>
                </tr>
                <tr style="white-space: nowrap">
                    <td width="30px">Nama Produk</td>
                    <td width="10px">:</td>
                    <td>{{ $manufacturingOrder->product->nama_produk ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>:</td>
                    <td>{{ $manufacturingOrder->jumlah_order }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>{{ $manufacturingOrder->status }}</td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Bahan Baku</th>
                    <th>Jumlah Bahan</th>
                </tr>
                @foreach ($manufacturingOrder->manufacturingOrderDetails as $item)
                <tr>
                    <td>{{ $item->material->nama_bahan }}</td>
                    <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</section>
@endsection