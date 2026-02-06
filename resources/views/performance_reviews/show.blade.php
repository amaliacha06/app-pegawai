@extends('master')
@section('title', 'Detail Kinerja Pegawai')
@section('page-title', 'Detail Kinerja Pegawai')
@section('content')

    @php
        $employee = $performanceReview->employee;
        $initials = collect(explode(' ', $employee->nama_lengkap))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->join('');

        // Generate random soft color based on name (agar avatar tiap orang beda tapi konsisten)
        $colors = ['#4E89AE', '#ED6663', '#FFA372', '#9ECAFB', '#4A70A9', '#B692FE'];
        $bgColor = $colors[ord(substr($employee->nama_lengkap, 0, 1)) % count($colors)];
    @endphp

    <div class="container-lg px-0">

        <div class="mb-3">
        <h2 class="fw-bold mb-0 text-dark">Individual Performance - Detail</h2>
    </div>

    <div class="card shadow-lg mb-3 rounded-4">
        <div class="card-body p-4">
            <div class="text-end mb-3">
                   <a href="{{ route('performance-reviews.index') }}" class="btn btn-lg shadow-sm border-0 fw-semibold custom-btn">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            </div>

            <div class="d-flex align-items-start mb-4">

                <!-- Avatar -->
                <div class="text-center me-4" style="margin-top: -15px;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 120px; height: 120px; background-color: {{ $bgColor }}; color: white; font-size: 38px; font-weight: bold;">
                        {{ $initials }}
                    </div>

                    @php
                        $employeeStatus = $employee->status ?? 'Aktif';
                        $statusClass = $employeeStatus == 'Aktif' ? 'bg-success':'bg-danger';
                    @endphp
                    <span class="badge {{ $statusClass }} mt-3 fs-6 px-3 py-2 rounded-pill shadow-sm">{{ $employeeStatus }}</span>
                </div>

                <!-- Data Pegawai + Score -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="fw-bold text-muted mb-1 mb-0">{{ $employee->nama_lengkap }}</h3>

                            <p class="text-muted mb-1">ID Pegawai:
                                <span class="fw-semibold">{{ $employee->id }}</span>
                            </p>

                            <p class="text-sm text-muted mb-0">
                                Periode Penilaian: <span class="fw-medium">{{ $performanceReview->period }}</span>
                            </p>
                        </div>

                        <!-- Score -->
                        <div class="text-center ms-4 p-3 bg-light rounded-lg shadow-sm" style="min-width: 100px;">
                            <span
                                class="d-block fs-2 fw-bolder text-info">{{ number_format($performanceReview->score, 1) }}</span>
                            <small class="d-block text-muted">/ 100</small>

                            @php
                                $starCount = min(5, max(0, round($performanceReview->score / 20)));
                            @endphp

                            <div class="text-warning mt-1">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $starCount)
                                        <i class="fas fa-star fa-sm"></i>
                                    @else
                                        <i class="far fa-star fa-sm"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Detail Informasi Pegawai -->
                    <div class="row row-cols-md-3 g-3 border-top pt-3">
                        <div class="col">
                            <small class="fw-semibold fs-6">Email</small>
                            <span class="text-muted d-block mb-0">{{ $employee->email }}</span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">No. Telepon</small>
                            <span class="text-muted d-block mb-0">{{ $employee->nomor_telepon }}</span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">Departemen</small>
                            <span class="text-muted d-block mb-0">
                                {{ $employee->department->nama_departemen ?? '-' }}
                            </span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">Jabatan</small>
                            <span class="text-muted d-block mb-0">
                                {{ $employee->position->nama_jabatan ?? '-' }}
                            </span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">Tanggal Masuk</small>
                            <span
                                class="text-muted d-block mb-0">{{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d M Y') }}</span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">Tanggal Lahir</small>
                            <span
                                class="text-muted d-block mb-0">{{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d M Y') }}</span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">Tanggal Review</small>
                            <span
                                class="text-muted d-block mb-0">{{ \Carbon\Carbon::parse($performanceReview->review_date)->format('d M Y') }}</span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">Status Review</small>
                            <span class="text-muted d-block mb-0">
                                {{ $performanceReview->status }}
                            </span>
                        </div>

                        <div class="col">
                            <small class="fw-semibold fs-6">Alamat</small>
                            <span class="text-muted d-block mb-0">{{ $employee->alamat }}</span>
                        </div>

            <div class="col-md-5">
            <div class="card h-100 shadow-sm border-info">
                <div class="card-header bg-info text-white fw-semibold">
                    <i class="fas fa-comment-dots me-2"></i> Feedback Atasan
                </div>
                <div class="card-body">
                    <p class="card-text text-muted mb-0" style="word-break: break-all;">{{ $performanceReview->feedback }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card h-100 shadow-sm border-warning">
                <div class="card-header bg-warning text-dark fw-semibold">
                    <i class="fas fa-lightbulb me-2"></i> Masukan Kinerja kedepannya
                </div>
                <div class="card-body">
                    <p class = "card-text text-muted mb-0" style="word-break: break-all;">
                        {{ $performanceReview->training_recommendation ?? 'Tidak ada rekomendasi khusus' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback & Rekomendasi -->
        

    <style>
.custom-btn {
    border-radius: 0.5rem;
    background-color: #d8edff;
    color: #226c8b;
    transition: all 0.3s ease;
}

.custom-btn:hover {
    background-color: #b3e3f8;
    color: #247ea4;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection