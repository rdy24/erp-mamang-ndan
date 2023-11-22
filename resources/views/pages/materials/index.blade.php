@extends('layouts.app')

@section('title')
Bahan Baku | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/datatables.net-bs4/css/dataTables.bootstrap4.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/datatables.net-select-bs4/css/select.bootstrap4.min.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>Bahan Baku</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard.') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Bahan Baku</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('dashboard.materials.create') }}" class="btn btn-primary"><i class="fas fa-plus"
                            aria-hidden="true"></i>
                        Tambah Data</a>
                    <a href="{{ route('dashboard.') }}" class=" btn btn-dark"><i class="fas fa-file-pdf"
                            aria-hidden="true"></i>
                        Cetak PDF</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Bahan</th>
                                    <th>Nama Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $material->kode_bahan }}</td>
                                    <td>{{ $material->nama_bahan }}</td>
                                    <td>{{ $material->jumlah }} {{ $material->satuan }}</td>
                                    <td>Rp. {{ number_format($material->harga) }}</td>
                                    <td>
                                        <img src="{{ $material->gambar ? asset('uploads/material/' . $material->gambar) :
                                        asset('assets/img/blank-image.png') }}" alt=""
                                            style="height: 100px; object-fit: cover; object-position: center;">
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.materials.edit', $material->id) }}"
                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('dashboard.materials.destroy', $material->id) }}"
                                            class="btn btn-danger" data-confirm-delete="true"><i
                                                class="fas fa-trash"></i></a>
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