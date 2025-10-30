@extends('master')
@section('title', 'Detail Pegawai')
@section('page-title', 'Detail Pegawai')
@section('content')

<div class="row justify-content-center">
    <h4 class="fw-semibold mb-2 text-center align-middle"> Detail Pegawai</h4>
    <div class="col-lg-7 col-md-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="w-25">Nama Lengkap</th>
                        <td>{{ $employee->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $employee->email }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ $employee->nomor_telepon }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $employee->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $employee->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ $employee->tanggal_masuk }}</td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td>{{ $employee->department->nama_departemen ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Position</th>
                        <td>{{ $employee->position->nama_jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $employee->status }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection