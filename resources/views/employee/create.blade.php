@extends('master')
@section('title', 'Tambah Pegawai')
@section('page-title', 'Tambah Pegawai')
@section('content')

<div class="row justify-content-center">
    <h4 class="fw-semibold mb-2 text-center align-middle"> Form Tambah Pegawai</h4>
    <div class=" col-lg-7 col-md-5 col-sm-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    <div class="mb-2 row">
                        <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                class="form-control @error('nama_lengkap') is-invalid @enderror">
                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="nomor_telepon" class="col-sm-3 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-9">
                            <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                class="form-control @error('nomor_telepon') is-invalid @enderror">
                            @error('nomor_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror">
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea id="alamat" name="alamat" rows="3"
                                class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="tanggal_masuk" class="col-sm-3 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-9">
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                                class="form-control @error('tanggal_masuk') is-invalid @enderror">
                            @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="departemen_id" class="col-sm-3 col-form-label">Department</label>
                        <div class="col-sm-9">
                            <select id="departemen_id" name="departemen_id"
                                class="form-select @error('departemen_id') is-invalid @enderror">
                                <option value="">-- Pilih Department --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('departemen_id') == $department->id ? 'selected' : '' }}>{{ $department->nama_departemen }}</option>
                                @endforeach
                            </select>
                            @error('departemen_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="jabatan_id" class="col-sm-3 col-form-label">Position</label>
                        <div class="col-sm-9">
                            <select id="jabatan_id" name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror">
                                <option value="">-- Pilih Position --</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('jabatan_id') == $position->id ? 'selected' : '' }}>{{ $position->nama_jabatan }}</option>
                                @endforeach
                            </select>
                            @error('jabatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection