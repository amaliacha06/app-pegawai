@extends('master')
@section('title', 'Absensi')
@section('page-title', 'Daftar Absensi')
@section('content')

    <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold mb-0">Daftar Absensi</h3>
        <a href="{{ route('attendance.create') }}" class="btn btn-primary">+ Tambah Absensi</a>
    </div>

    <div class="mb-3">
        <form action="{{ route('attendance.index') }}" method="GET">
            <div class= "input-group" style="width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" style="display: none;"></button>

                @if(request('search'))
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-danger" title="Hapus Filter">❌</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0 text-center align middle">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Tanggal</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $a)
                        <tr>
                            <td>{{ $a->employee->nama_lengkap ?? '-' }}</td>
                            <td>{{ $a->tanggal }}</td>
                            <td>{{ $a->waktu_masuk ?? '-' }}</td>
                            <td>{{ $a->waktu_keluar ?? '-' }}</td>
                            <td>{{ $a->status_absensi }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('attendance.show', $a->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('attendance.edit', $a->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form id="delete-form-{{ $a->id }}" action="{{ route('attendance.destroy', $a->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete(event, {{ $a->id }})">Delete</button>
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
        {{ $attendances->withQueryString()->links() }}
    </div>
@endsection