@extends('layouts.app')

@section('title')
Tambah Order | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/select2/dist/css/select2.min.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/selectric/public/selectric.css") }}>
<link rel="stylesheet" href={{ asset("assets/module/bootstrap-tagsinput/dist/bootstrap-tagsinput.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>Tambah Order</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Tambah Order</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.manufacturing-orders.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="id_produk">Produk</label>
                            <select name="id_produk" required class="form-control select2">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('id_produk')==$product->id ? 'selected' : ''
                                    }}>
                                    {{ $product->nama_produk }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_bom">BOM</label>
                            <select name="id_bom" required class="form-control select2" id="id_bom"
                                onchange="resetJumlah()">
                                <option value="">-- Pilih BOM --</option>
                                @foreach($bom as $item)
                                <option value="{{ $item->id }}" {{ old('id_bom')==$item->id ? 'selected' : ''
                                    }}>
                                    {{ $item->kode_bom }} - {{ $item->product->nama_produk ?? 'Tidak Ada Produk' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_order">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah_order" name="jumlah_order" required
                                value="{{ old('jumlah_order') }}">
                            @error('jumlah_order')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_bahan">Bahan Baku</label>
                            <div id="bahan-baku-container">

                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-primary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js-libraries')
<script src={{ asset("assets/module/select2/dist/js/select2.full.min.js") }}></script>
<script src={{ asset("assets/module/selectric/public/jquery.selectric.min.js") }}></script>
<script src={{ asset("assets/module/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js") }}></script>
@endpush

@push('js-page')
<script>
    // Menggunakan JavaScript untuk menangani peristiwa 'keydown' pada input
    document.getElementById('jumlah_order').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Mencegah form dari submit
            sendDataToBackend();
        }
    });

    function resetJumlah() {
        document.getElementById('jumlah_order').value = 1;
        sendDataToBackend();
    }

    // Fungsi untuk mengirim data ke backend
    function sendDataToBackend() {
        // Dapatkan nilai input
        let jumlahValue = document.getElementById('jumlah_order').value;
        let bomId = document.getElementById('id_bom').value;

        if (jumlahValue == '' || bomId == '') {
            return;
        }

        //  fetch to '/get-bom' dengan method get
        fetch(`/get-bom/${jumlahValue}/${bomId}`, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                // Ambil elemen dengan ID "bahan-baku-container"
                const bahanBakuContainer = document.getElementById('bahan-baku-container');
                
                // Buat HTML baru berdasarkan data yang diterima
                let newHTML = '';
                
                data.bomDetail.forEach(item => {
                newHTML += `
                    <div class="row form-bahan-baku mb-2">
                        <div class="col-md-5">
                            <select name="id_bahan[]" class="form-control">
                                <option value="${item.id_bahan}">${item.nama_bahan}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="jumlah_bahan[]" readonly value="${item.jumlah}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="satuan[]" readonly value="${item.satuan}">
                        </div>
                    </div>
                `;
                })

                bahanBakuContainer.innerHTML = newHTML;
            })
            .catch(error => {
                console.error(error);
            });
            
    }
</script>
@endpush