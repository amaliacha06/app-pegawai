@extends('master')
@section('title', 'Detail Absensi')
@section('page-title', 'Detail Absensi')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <h4 class="fw-semibold mb-4 text-center align-middle"> Detail Kehadiran Pegawai</h4>
        <div class="card">
            <div class="card-header">
                <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="w-26">Karyawan</th>
                        <td>{{ $attendance->employee->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $attendance->tanggal }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Masuk</th>
                        <td>{{ $attendance->waktu_masuk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Keluar</th>
                        <td>{{ $attendance->waktu_keluar ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $attendance->status_absensi }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
