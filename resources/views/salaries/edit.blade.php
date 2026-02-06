@extends('master')
@section('title', 'Edit Gaji')
@section('page-title', 'Edit Gaji')
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <h4 class="fw-semibold mb-2 text-center align-middle"> Form Edit Gaji</h4>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="karyawan_id" class="form-label">Karyawan</label>
                            <select id="karyawan_id" name="karyawan_id"
                                class="form-select @error('karyawan_id') is-invalid @enderror">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" data-gaji="{{ $emp->position_gaji ?? 0 }}" {{ old('karyawan_id', $salary->karyawan_id) == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="bulan" class="form-label fw-bold">Periode</label>
                            <input type="text" name="bulan" id="bulan" value="{{ old('bulan') }}"
                                class="form-control @error('bulan') is-invalid @enderror" placeholder="ex: November">
                            @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                            <input type="number" step="0.01" id="gaji_pokok" name="gaji_pokok"
                                value="{{ old('gaji_pokok', $salary->gaji_pokok) }}"
                                class="form-control @error('gaji_pokok') is-invalid @enderror">
                            @error('gaji_pokok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="tunjangan" class="form-label">Tunjangan</label>
                            <input type="number" step="0.01" id="tunjangan" name="tunjangan"
                                value="{{ old('tunjangan', $salary->tunjangan) }}"
                                class="form-control @error('tunjangan') is-invalid @enderror">
                            @error('tunjangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="potongan" class="form-label">Potongan</label>
                            <input type="number" step="0.01" id="potongan" name="potongan"
                                value="{{ old('potongan', $salary->potongan) }}"
                                class="form-control @error('potongan') is-invalid @enderror">
                            @error('potongan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('salaries.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            const sel = document.getElementById('karyawan_id');
            const gajiInput = document.getElementById('gaji_pokok');
            if (!sel) return;
            sel.addEventListener('change', function () {
                const opt = sel.selectedOptions[0];
                if (!opt) return;
                const gaji = opt.dataset.gaji || 0;
                if (gajiInput) gajiInput.value = gaji;
            });
            // trigger on load if an employee is preselected
            if (sel.value) {
                const opt = sel.selectedOptions[0];
                if (opt && gajiInput) gajiInput.value = opt.dataset.gaji || gajiInput.value;
            }
        })();
    </script>
@endsection