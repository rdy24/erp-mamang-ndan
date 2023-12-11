@extends('layouts.app')

@section('title')
Quotation Template | {{ config('app.name') }}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $template->title }}</h1>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('dashboard.quotation-template.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div>
            <a href="{{ route('dashboard.quotation-template.edit', $template->id) }}" class="btn btn-warning">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('dashboard.quotation-template.destroy', $template->id) }}" class="btn btn-danger"
                data-confirm-delete="true">
                <i class="fas fa-trash"></i> Hapus
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Expired</th>
                </tr>
                <tr>
                    <td>{{ $template->expired }} (Hari)</td>
                </tr>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                </tr>
                @foreach ($template->template_details as $item)
                <tr>
                    <td>{{ $item->product->nama_produk }}</td>
                    <td>{{ $item->qty }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</section>
@endsection