@extends('layouts.app')

@section('title')
Dashboard | {{ config('app.name') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $bom->kode_bom }}</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('dashboard.bom.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div>
            <a href="{{ route('dashboard.bom.edit', $bom->id) }}" class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('dashboard.bom.destroy', $bom->id) }}" class="btn btn-danger" data-confirm-delete="true">
                <i class="fas fa-trash"></i> Hapus
            </a>
            <a href="{{ route('dashboard.bom.print', $bom->id) }}" class="btn btn-dark">
                <i class="fas fa-file-pdf"></i> Print
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th colspan="2">Produk</th>
                    <th>Harga</th>
                </tr>
                <tr>
                    <td colspan="2">{{ $bom->product->nama_produk }}</td>
                    <td>Rp. {{ number_format($bom->product->harga) }}</td>
                </tr>
                <tr>
                    <th>Bahan</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
                @foreach ($bom->bomDetail as $item)
                <tr>
                    <td>{{ $item->material->nama_bahan }}</td>
                    <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                    <td>Rp. {{ number_format($item->subtotal) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total</th>
                    <th>Rp. {{ number_format($item->totalHarga) }}</th>
                </tr>
            </table>
        </div>
    </div>
</section>
@endsection