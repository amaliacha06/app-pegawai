@extends('master')
@section('title', 'Edit Departemen')
@section('page-title', 'Edit Departemen')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <h4 class="fw-semibold mb-4 text-center align-middle"> Form Edit Departemen</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_departemen" class="form-label fw-semibold mb-3">Nama Departemen</label>
                        <input type="text" id="nama_departemen" name="nama_departemen" value="{{ old('nama_departemen', $department->nama_departemen) }}"
                            class="form-control @error('nama_departemen') is-invalid @enderror">
                        @error('nama_departemen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection