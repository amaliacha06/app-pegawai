@extends('master')
@section('title', 'Edit Absensi')
@section('page-title', 'Edit Absensi')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-5 col-md-8">
        <h4 class="fw-semibold mb-4 text-center align-middle"> Form Edit Kehadiran</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Karyawan</label>
                        <select id="karyawan_id" name="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('karyawan_id', $attendance->karyawan_id) == $emp->id ? 'selected' : '' }}>{{ $emp->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('karyawan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $attendance->tanggal) }}" class="form-control @error('tanggal') is-invalid @enderror">
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_masuk" class="form-label">Waktu Masuk (HH:MM)</label>
                        <input type="time" id="waktu_masuk" name="waktu_masuk" value="{{ old('waktu_masuk', $attendance->waktu_masuk) }}" class="form-control @error('waktu_masuk') is-invalid @enderror">
                        @error('waktu_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_keluar" class="form-label">Waktu Keluar (HH:MM)</label>
                        <input type="time" id="waktu_keluar" name="waktu_keluar" value="{{ old('waktu_keluar', $attendance->waktu_keluar) }}" class="form-control @error('waktu_keluar') is-invalid @enderror">
                        @error('waktu_keluar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_absensi" class="form-label">Status Absensi</label>
                        <select id="status_absensi" name="status_absensi" class="form-select @error('status_absensi') is-invalid @enderror">
                            <option value="hadir" {{ old('status_absensi', $attendance->status_absensi) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ old('status_absensi', $attendance->status_absensi) == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('status_absensi', $attendance->status_absensi) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="alpha" {{ old('status_absensi', $attendance->status_absensi) == 'alpha' ? 'selected' : '' }}>Alpha</option>
                        </select>
                        @error('status_absensi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end">
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
