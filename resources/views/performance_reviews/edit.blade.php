@extends('master')
@section('title', 'Edit Kinerja Pegawai')
@section('page-title', 'Edit Kinerja Pegawai')
@section('content')

    <div class="row justify-content-center">
        {{-- Pembatas Lebar Form: Col-md-8 dan offset-md-2 untuk membuat form ramping di tengah --}}
        <div class="col-md-8">

            <h4 class="fw-semibold mb-2 text-center"> Form Edit Penilaian: {{ $performanceReview->employee->nama_lengkap }}
            </h4>

            <div class="card p-4 shadow-sm">
                <div class="card-body">
                    {{-- Form diarahkan ke metode STORE --}}
                    <form action="{{ route('performance-reviews.update', $performanceReview->id) }}" method="POST"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="employee_id" value="{{ $performanceReview->employee_id }}">

                        {{-- KODE DARI form.blade.php DIMULAI DI SINI --}}
                        <div class="row">
                            {{-- Input Pegawai (Dropdown, dinonaktifkan saat Edit) --}}
                            <div class="col-md-6 mb-3">
                                <label for="employee_id" class="form-label fw-bold">Pegawai yang Dinilai <span
                                        class="text-danger">*</span></label>
                                <select name="employee_id" id="employee_id" class="form-control" disabled>
                                    {{-- Tampilkan pegawai yang sedang dinilai --}}
                                    <option value="{{ $performanceReview->employee_id }}" selected>
                                        {{ $performanceReview->employee->nama_lengkap }} (ID:
                                        {{ $performanceReview->employee->id }})
                                    </option>
                                </select>
                                {{-- Input Hidden untuk mengirim ID agar Controller tahu Pegawai mana yang diupdate --}}
                                <input type="hidden" name="employee_id" value="{{ $performanceReview->employee_id }}">
                            </div>

                            {{-- Input Periode --}}
                            <div class="col-md-6 mb-3">

                                <label for="period" class="form-label fw-bold">Periode Penilaian <span
                                        class="text-danger">*</span></label>

                                {{-- KODE YANG PERLU DIUBAH ADA DI BAWAH INI --}}
                                <input type="text" name="period" id="period" class="form-control @error('period') is-invalid @enderror" placeholder="ex: November 2024"
    value="{{ old('period', $performanceReview->period) }}">
                                {{-- SAMPAI DI SINI --}}

                                @error('period') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            </div>
                        </div>

                        <div class="row">
                            {{-- Input Tanggal Review --}}
                            <div class="col-md-4 mb-3">
                                <label for="review_date" class="form-label fw-bold">Tanggal Review <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="review_date" id="review_date"
                                    class="form-control @error('review_date') is-invalid @enderror" required
                                    value="{{ old('review_date', $performanceReview->review_date) }}">
                                @error('review_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Input Skor (0-100) --}}
                            <div class="col-md-4 mb-3">
                                <label for="score" class="form-label fw-bold">Skor (0-100) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="score" id="score"
                                    class="form-control @error('score') is-invalid @enderror" step="0.01" min="0" max="100"
                                    required value="{{ old('score', $performanceReview->score) }}">
                                @error('score') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Input Status --}}
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label fw-bold">Status <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    @php $currentStatus = old('status', $performanceReview->status); @endphp
                                    <option value="In Progress" @if($currentStatus == 'In Progress') selected @endif>In
                                        Progress</option>
                                    <option value="Completed" @if($currentStatus == 'Completed') selected @endif>Completed
                                    </option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Input Feedback --}}
                        <div class="mb-1">
                            <label for="feedback" class="form-label fw-bold">Feedback / Komentar Atasan <span
                                    class="text-danger">*</span></label>
                            <textarea name="feedback" id="feedback"
                                class="form-control @error('feedback') is-invalid @enderror" rows="3"
                                required>{{ old('feedback', $performanceReview->feedback) }}</textarea>
                            @error('feedback') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Input Rekomendasi Training --}}
                        <div class="mb-1">
                            <label for="training_recommendation" class="form-label fw-bold">Masukan Kinerja
                                Selanjutnya</label>
                            <textarea name="training_recommendation" id="training_recommendation"
                                class="form-control @error('training_recommendation') is-invalid @enderror"
                                rows="3">{{ old('training_recommendation', $performanceReview->training_recommendation) }}</textarea>
                            @error('training_recommendation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        {{-- KODE DARI form.blade.php BERAKHIR DI SINI --}

                        {{-- Tombol Batal dan Simpan Rata Kanan --}}
                        <div class="d-flex justify-content-end pt-2">
                            <a href="{{ route('performance-reviews.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection