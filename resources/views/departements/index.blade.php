@extends('master')
@section('title', 'Daftar Departemen')
@section('page-title', 'Daftar Departemen')
@section('content')

    <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold mb-0 ">Daftar Departmen</h3>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">+ Tambah Departemen</a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0 text-center align middle">
                <thead>
                    <tr>
                        <th>Nama Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{ $department->nama_departemen }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('departments.show', $department->id) }}"
                                    class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('departments.edit', $department->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $departments->links() }}
    </div>
@endsection