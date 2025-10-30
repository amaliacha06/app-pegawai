@extends('master')
@section('title', 'Tambah Departemen')
@section('page-title', 'Tambah Departemen')
@section('content')

<div class="row justify-content-center">
    <h4 class="fw-semibold mb-4 text-center align-middle">Form Tambah Departemen</h4>
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="nama_departemen" class="form-label">Nama Departemen</label>
                        <input type="text" id="nama_departemen" name="nama_departemen" value="{{ old('nama_departemen') }}"
                            class="form-control @error('nama_departemen') is-invalid @enderror">
                        @error('nama_departemen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection