@extends('master')
@section('title', 'Daftar Jabatan')
@section('page-title', 'Daftar Jabatan')
@section('content')

    <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class=" fw-semibold mb-0">Daftar Jabatan</h3>
        <a href="{{ route('positions.create') }}" class="btn btn-primary"> + Tambah Jabatan</a>
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
                                <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $positions->links() }}
    </div>
@endsection