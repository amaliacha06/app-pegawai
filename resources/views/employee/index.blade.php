@extends('master')
@section('title', 'Daftar Pegawai')
@section('page-title', 'Daftar Pegawai')
@section('content')

    <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold mb-0">Daftar Pegawai</h3>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Tambah Pegawai</a>
    </div>

    <div class="mb-3">
        <form action="{{ route('employees.index') }}" method="GET">
            <div class="input-group" style="width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" style="display: none;"></button>

                @if(request('search'))
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-danger" title="Hapus Filter">❌</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0 text-center align-middle">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->nama_lengkap }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->nomor_telepon }}</td>
                            <td>{{ $employee->tanggal_lahir }}</td>
                            <td>{{ $employee->alamat }}</td>
                            <td>{{ $employee->tanggal_masuk }}</td>
                            <td>{{ $employee->status }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form id="delete-form-{{ $employee->id }}"
                                    action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete(event, {{ $employee->id }})">Delete</button>
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
        {{ $employees->withQueryString()->links() }}
    </div>

@endsection