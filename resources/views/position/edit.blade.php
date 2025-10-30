@extends('master')
@section('title', 'Edit Jabatan')
@section('page-title', 'Edit Jabatan')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <h4 class="fw-semibold mb-2 text-center align-middle"> Form Edit Jabatan</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('positions.update', $position->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan', $position->nama_jabatan) }}"
                            class="form-control @error('nama_jabatan') is-invalid @enderror">
                        @error('nama_jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <input type="number" step="0.01" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $position->gaji_pokok) }}"
                            class="form-control @error('gaji_pokok') is-invalid @enderror">
                        @error('gaji_pokok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('positions.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection