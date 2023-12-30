@extends('layouts.app')

@section('title')
Employee | {{ config('app.name') }}
@endsection


@section('content')
<section class="section">
    <div class="section-header">
        <h1>Employee</h1>
    </div>
    <div class="row mb-3">
        <div class="col-md-9">
            <form action="" class="d-flex">
                <input type="text" class="form-control" placeholder="search here" name="search"
                    value="{{ request()->search }}">
                <button class="btn btn-primary ml-2">Search</button>
            </form>
        </div>
        <div class="col-md-3">
            <a href="{{ route('dashboard.employees.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah employee
            </a>
            <a href="{{ route('dashboard.employees.print') }}" class="btn btn-primary">
                <img src="{{ asset('assets/img/vuesax/bold/document-download.png') }}" alt="icon download"
                    style="height: 25px">
            </a>
        </div>
    </div>
    @forelse ($employees as $employee)
    <div class="card px-2 py-3">
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $employee->photo ? asset('uploads/employee/' . $employee->photo) : asset('assets/img/blank-image.png') }}"
                    alt="" style="width: 250px; object-fit: cover; object-position: center;">
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-9">
                        <table class="table table-sm">
                            <tr style="white-space: nowrap">
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $employee->name }}</td>
                            </tr>
                            <tr style="white-space: nowrap">
                                <td>Job Position</td>
                                <td>:</td>
                                <td>{{ $employee->jobPosition->name }}</td>
                            </tr>
                            <tr style="white-space: nowrap">
                                <td>Department</td>
                                <td>:</td>
                                <td>{{ $employee->department->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{ $employee->phone_number }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $employee->address }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('dashboard.employees.destroy', $employee->id) }}" class="btn btn-danger" data-confirm-delete="true">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">
        Tidak ada employee
    </div>
    @endforelse

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</section>
@endsection