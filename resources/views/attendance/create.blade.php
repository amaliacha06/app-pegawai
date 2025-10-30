@extends('master')
@section('title', 'Tambah Absensi')
@section('page-title', 'Tambah Absensi')
@section('content')

<div class="row justify-content-center">
    <h4 class="fw-semibold mb-4 text-center align-middle"> Tambah Absensi</h4>
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Karyawan</label>
                        <select id="karyawan_id" name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('karyawan_id') == $emp->id ? 'selected' : '' }}>{{ $emp->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('karyawan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" lang="id" value="{{ old('tanggal') }}" class="form-control @error('tanggal') is-invalid @enderror">
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_masuk" class="form-label">Waktu Masuk (HH:MM)</label>
                        <input type="time" id="waktu_masuk" name="waktu_masuk" value="{{ old('waktu_masuk') }}" class="form-control @error('waktu_masuk') is-invalid @enderror">
                        @error('waktu_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_keluar" class="form-label">Waktu Keluar (HH:MM)</label>
                        <input type="time" id="waktu_keluar" name="waktu_keluar" value="{{ old('waktu_keluar') }}" class="form-control @error('waktu_keluar') is-invalid @enderror">
                        @error('waktu_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_absensi" class="form-label">Status Absensi</label>
                        <select id="status_absensi" name="status_absensi" class="form-select @error('status_absensi') is-invalid @enderror">
                            <option value="hadir" {{ old('status_absensi') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ old('status_absensi') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('status_absensi') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="alpha" {{ old('status_absensi') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                        </select>
                        @error('status_absensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
