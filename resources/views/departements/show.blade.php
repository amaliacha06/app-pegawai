@extends('master')
@section('title', 'Detail Departemen')
@section('page-title', 'Detail Departemen')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <h4 class="fw-semibold mb-4 text-center align-middle"> Detail Departemen</h4>
        <div class="card">
            <div class="card-header">
                <a href="{{ route('departments.index') }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="w-26">Nama Departemen</th>
                        <td>{{ $department->nama_departemen }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pegawai</th>
                        <td>{{ $department->employees()->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection