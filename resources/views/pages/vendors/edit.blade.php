@extends('layouts.app')

@section('title')
Edit vendor | {{ config('app.name') }}
@endsection

@section('content')
<div class="section-header">
    <h1>Edit vendor</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Edit vendor</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.vendors.update', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="type">Tipe</label>
                            <div class="d-flex">
                                <div class="form-check mr-2">
                                    <input class="form-check-input" type="radio" name="type" id="type1" value="company"
                                        {{ old('type', 'company', $vendor->type)=='company' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type1">
                                        Company
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type"
                                        value="individual" {{ old('type', $vendor->type)=='individual' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type">
                                        Individual
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name', $vendor->name) }}">
                            @error('name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div id="individual-vendor" style="display: none">
                            <div class="form-group">
                                <label for="company_name">Company</label>
                                <select name="company_name" class="form-control" id="company_name">
                                    <option value="">Pilih vendor</option>
                                    @foreach($vendors as $item)
                                    <option value="{{ $item->name }}" {{ old('company_name')==$item->id ?
                                        'selected' :
                                        ''
                                        }} data-id={{ $item->id }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="position">Jabatan</label>
                                <input type="text" class="form-control" id="position" name="position"
                                    value="{{ old('position', $vendor->position) }}">
                                @error('position')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="{{ old('email', $vendor->email) }}">
                            @error('email')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Phone</label>
                            <input type="phone" class="form-control" id="phone" name="phone" required
                                value="{{ old('phone', $vendor->phone) }}">
                            @error('phone')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Alamat</label>
                            <input type="address" class="form-control" id="address" name="address" required
                                value="{{ old('address', $vendor->address) }}">
                            @error('address')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="form-label">Foto</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5 d-block">
                            <input class="form-control-file" type="file" id="gambar" name="gambar" onchange="previewImage()" src="{{ $vendor->gambar ? asset('uploads/vendor/' . $vendor->gambar) : '' }}">
                            @error('gambar')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('dashboard.vendors.index') }}" class="btn btn-outline-primary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js-page')
<script>
    function previewImage() {
        const gambar = document.querySelector('#gambar');
        const imgPreview = document.querySelector('.img-preview');
        const blob = URL.createObjectURL(gambar.files[0]);
        imgPreview.src = blob;
    }

    $('input[type=radio][name=type]').change(function() {
        if (this.value == 'individual') {
            $('#individual-vendor').show();
        } else {
            $('#individual-vendor').hide();
        }
    });

    // if company_name change fetch to getvendor
    $('#company_name').change(function() {
        const company_name = $(this).val();
        const id = $(this).find(':selected').data('id');

        $.ajax({
            url: `/get-vendor/${id}`,
            type: "GET",
            data: {
                id: id
            },
            success: function(data) {
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
            }
        });
        
    });
</script>
@endpush