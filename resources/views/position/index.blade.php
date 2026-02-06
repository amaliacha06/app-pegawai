@extends('master')
@section('title', 'Daftar Jabatan')
@section('page-title', 'Daftar Jabatan')
@section('content')

    <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold mb-0">Daftar Jabatan</h3>
        <a href="{{ route('positions.create') }}" class="btn btn-primary">+ Tambah Jabtan</a>
    </div>

    <div class="mb-3">
        <form action="{{ route('positions.index') }}" method="GET">
            <div class="input-group" style="width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" style="display: none;"></button>

                @if(request('search'))
                    <a href="{{ route('positions.index') }}" class="btn btn-outline-danger" title="Hapus Filter">❌</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0 text-center align middle">
                <thead>
                    <tr>
                        <th>Nama Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                        <tr>
                            <td>{{ $position->nama_jabatan }}</td>
                            <td>{{ number_format($position->gaji_pokok, 2, ',', '.') }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('positions.show', $position->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form id="delete-form-{{ $position->id }}" 
                                    action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-inline"> 
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(event, {{ $position->id }})">Delete</button>
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
        {{ $positions->withQueryString()->links() }}
    </div>
@endsection