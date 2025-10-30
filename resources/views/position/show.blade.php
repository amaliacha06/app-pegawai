@extends('master')
@section('title', 'Detail Jabatan')
@section('page-title', 'Detail Jabatan')
@section('content')

<div class="row justify-content-center">
    <h4 class="fw-semibold mb-2 text-center align-middle"> Detail Jabatan</h4>
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('positions.index') }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="w-25">Nama Jabatan</th>
                        <td>{{ $position->nama_jabatan }}</td>
                    </tr>
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>{{ number_format($position->gaji_pokok, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pegawai</th>
                        <td>{{ $position->employees()->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection