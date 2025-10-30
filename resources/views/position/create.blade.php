@extends('master')
@section('title', 'Tambah Jabatan')
@section('page-title', 'Tambah Jabatan')
@section('content')

<div class="row justify-content-center">
    <h4 class="fw-semibold mb-2 text-center align-middle"> Form Tambah Jabatan</h4>
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('positions.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan') }}"
                            class="form-control @error('nama_jabatan') is-invalid @enderror">
                        @error('nama_jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <input type="number" step="0.01" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}"
                            class="form-control @error('gaji_pokok') is-invalid @enderror">
                        @error('gaji_pokok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('positions.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection