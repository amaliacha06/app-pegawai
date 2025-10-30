@extends('master')
@section('title', 'Detail Gaji')
@section('page-title', 'Detail Gaji')
@section('content')

 
<div class=" row justify-content-center">
    <h4 class="fw-semibold mb-2 text-center align-middle"> Detail Gaji Pegawai</h4>
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('salaries.index') }}" class="btn btn-sm btn-secondary float-end">Kembali</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="w-25">Karyawan</th>
                        <td>{{ $salary->employee->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Bulan</th>
                        <td>{{ $salary->bulan }}</td>
                    </tr>
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>{{ number_format($salary->gaji_pokok,2,',','.') }}</td>
                    </tr>
                    <tr>
                        <th>Tunjangan</th>
                        <td>{{ number_format($salary->tunjangan,2,',','.') }}</td>
                    </tr>
                    <tr>
                        <th>Potongan</th>
                        <td>{{ number_format($salary->potongan,2,',','.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Gaji</th>
                        <td>{{ number_format($salary->total_gaji,2,',','.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
