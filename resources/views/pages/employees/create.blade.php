@extends('layouts.app')

@section('title')
Tambah Employee | {{ config('app.name') }}
@endsection

@push('css-libraries')
<link rel="stylesheet" href={{ asset("assets/module/select2/dist/css/select2.min.css") }}>
@endpush

@section('content')
<div class="section-header">
    <h1>Tambah Employee</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item active">Tambah Employee</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name') }}">
                            @error('name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" class="form-control select2" id="department_id">
                                <option value="">Pilih departemen</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id')==$department->id ? 'selected' :''}}>
                                    {{ $department->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="job_position_id">Job Position</label>
                            <select name="job_position_id" class="form-control select2" id="job_position_id">
                                <option value="">Pilih Job Position</option>
                                @foreach($jobPositions as $jobPosition)
                                <option value="{{ $jobPosition->id }}" {{ old('job_position_id')==$jobPosition->id ? 'selected' :''}}>
                                    {{ $jobPosition->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="{{ old('email') }}">
                            @error('email')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Phone</label>
                            <input type="phone_number" class="form-control" id="phone_number" name="phone_number" required
                                value="{{ old('phone_number') }}">
                            @error('phone_number')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Alamat</label>
                            <input type="address" class="form-control" id="address" name="address" required
                                value="{{ old('address') }}">
                            @error('address')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="photo" class="form-label">Foto</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5 d-block">
                            <input class="form-control-file" type="file" id="photo" name="photo"
                                onchange="previewImage()">
                            @error('photo')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('dashboard.customers.index') }}" class="btn btn-outline-primary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js-libraries')
<script src={{ asset("assets/module/select2/dist/js/select2.full.min.js") }}></script>
@endpush

@push('js-page')
<script>
    function previewImage() {
        const photo = document.querySelector('#photo');
        const imgPreview = document.querySelector('.img-preview');
        const blob = URL.createObjectURL(photo.files[0]);
        imgPreview.src = blob;
    }

    $("#job_position_id").prop('disabled', true);

    $('#department_id').change(function () {
        var department_id = $(this).val();
        if (department_id) {
            $("#job_position_id").prop('disabled', false);
            $.ajax({
                type: "GET",
                url: "/get-jobPositions/" + department_id,
                success: function (res) {
                    console.log(res);
                    if (res.jobPositions && res.jobPositions.length > 0) {
                        $("#job_position_id").empty();
                        $("#job_position_id").append('<option value="">Pilih Job Position</option>');
                        
                        $.each(res.jobPositions, function (index, jobPosition) {
                            $("#job_position_id").append('<option value="' + jobPosition.id + '">' + jobPosition.name +
                                '</option>');
                        });
                    } else {
                        $("#job_position_id").empty();
                        $("#job_position_id").append('<option value="">Tidak ada Job Position</option>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $("#job_position_id").prop('disabled', true);
            $("#job_position_id").empty();
            $("#job_position_id").append('<option value="">Pilih Departemen terlebih dahulu</option>');
        }
    });

</script>
@endpush