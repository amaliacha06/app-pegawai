@extends('master')
@section('title', 'Gaji')
@section('page-title', 'Daftar Gaji')
@section('content')

    <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold mb-0">Daftar Gaji</h3>
        <a href="{{ route('salaries.create') }}" class="btn btn-primary">+ Tambah Daftar Gaji</a>
    </div>

    <div class="mb-3">
        <form action="{{ route('salaries.index') }}" method="GET">
            <div class="input-group" style="width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" style="display: none;"></button>

                @if(request('search'))
                    <a href="{{ route('salaries.index') }}" class="btn btn-outline-danger" title="Hapus Filter">❌</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0 text-center align middle">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Bulan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Potongan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaries as $s)
                        <tr>
                            <td>{{ $s->employee->nama_lengkap ?? '-' }}</td>
                            <td>{{ $s->bulan }}</td>
                            <td>{{ number_format($s->gaji_pokok,2,',','.') }}</td>
                            <td>{{ number_format($s->tunjangan,2,',','.') }}</td>
                            <td>{{ number_format($s->potongan,2,',','.') }}</td>
                            <td>{{ number_format($s->total_gaji,2,',','.') }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('salaries.show', $s->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('salaries.edit', $s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form id="delete-form-{{ $s->id }}" 
                                    action="{{ route('salaries.destroy', $s->id) }}" method="POST" class="d-inline"> 
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(event, {{ $s->id }})">Delete</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class=" d-flex justify-content-end mt-3">
        {{-- Pastikan ini menggunakan withQueryString() untuk mempertahankan filter search --}}
        {{ $salaries->withQueryString()->links() }}
    </div>

@endsection
