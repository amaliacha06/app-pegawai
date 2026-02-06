@extends('master')
@section('title', 'Daftar Departemen')
@section('page-title', 'Daftar Departemen')
@section('content')

    <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold mb-0">Daftar Departemen</h3>
        <a href="{{ route('departments.create') }}" class="btn btn-primary">+ Tambah Departemen</a>
    </div>

    <div class="mb-3">
        <form action="{{ route('departments.index') }}" method="GET">
            <div class="input-group" style="width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" style="display: none;"></button>
                
                @if(request('search'))
                    <a href="{{ route('departments.index') }}" class="btn btn-outline-danger" title="Hapus Filter">❌</a>
                @endif
            </div>
        </form>
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
                                 <form id="delete-form-{{ $department->id }}" 
                                    action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline"> 
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(event, {{ $department->id }})">Delete</button>
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
        {{ $departments->withQueryString()->links() }}
    </div>
@endsection