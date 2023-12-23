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
            @if ($manufacturingOrder->material_status == 'not-available' || $manufacturingOrder->material_status == null)
            <a href="{{ route('dashboard.manufacturing-orders.check-material', $manufacturingOrder->id) }}"
                class="btn btn-warning">
                <i class="fas fa-check"></i> Check Availability
            </a>
            @endif
            @if ($manufacturingOrder->status == 'Draft' && $manufacturingOrder->material_status == 'available')
            <a href="{{ route('dashboard.manufacturing-orders.confirm', $manufacturingOrder->id) }}"
                class="btn btn-success">
                <i class="fas fa-check"></i> Confirm
            </a>
            @endif
            @if ($manufacturingOrder->status == 'Confirmed' && $manufacturingOrder->material_status == 'available')
            <a href="{{ route('dashboard.manufacturing-orders.todo', $manufacturingOrder->id) }}"
                class="btn btn-primary">
                <i class="fas fa-check"></i> To Do
            </a>
            @endif
            @if ($manufacturingOrder->status == 'To-Do' && $manufacturingOrder->material_status == 'available')
            <a href="{{ route('dashboard.manufacturing-orders.progress', $manufacturingOrder->id) }}"
                class="btn btn-dark">
                <i class="fas fa-procedures"></i> Produce
            </a>
            @endif
            @if ($manufacturingOrder->status == 'In-Progress' && $manufacturingOrder->material_status == 'available')
            <a href="{{ route('dashboard.manufacturing-orders.done', $manufacturingOrder->id) }}"
                class="btn btn-success">
                <i class="fas fa-check-square"></i> Done
            </a>
            @endif
        </div>
        <div>
            @if ($manufacturingOrder->status == 'Draft')
            <a href="{{ route('dashboard.manufacturing-orders.edit', $manufacturingOrder->id) }}"
                class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('dashboard.manufacturing-orders.destroy', $manufacturingOrder->id) }}"
                class="btn btn-danger" data-confirm-delete="true">
                <i class="fas fa-trash"></i> Hapus
            </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <tr style="white-space: nowrap">
                    <td width="100px">BOM</td>
                    <td width="20px">:</td>
                    <td>{{ $manufacturingOrder->bom->kode_bom ?? '-' }} - {{
                        $manufacturingOrder->bom->product->nama_produk ?? '-' }}</td>
                </tr>
                <tr style="white-space: nowrap">
                    <td width="100px">Nama Produk</td>
                    <td width="20px">:</td>
                    <td>{{ $manufacturingOrder->product->nama_produk ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>:</td>
                    <td>{{ $manufacturingOrder->jumlah_order }}</td>
                </tr>
                @if ($manufacturingOrder->material_status)
                    <tr style="white-space: nowrap">
                        <td>Material Status</td>
                        <td>:</td>
                        <td class="text-capitalize">{{ $manufacturingOrder->material_status }}</td>
                    </tr>
                @endif
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