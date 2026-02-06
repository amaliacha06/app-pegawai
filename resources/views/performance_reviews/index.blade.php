@extends('master')
@section('title', 'Kinerja Pegawai')
@section('page-title', 'Kinerja Pegawai')
@section('content')

     <div class="mb-3 mt-3 d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold mb-0">Kinerja Pegawai</h3>
        <a href="{{ route('performance-reviews.create') }}" class="btn btn-primary">+ Tambah Pegawai</a>
    </div>

    <div class="mb-3">
        <form action="{{ route('performance-reviews.index') }}" method="GET">
            <div class="input-group" style="width: 240px;">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                <button type="submit" style="display: none;"></button>

                @if(request('search'))
                    <a href="{{ route('performance-reviews.index') }}" class="btn btn-outline-danger" title="Hapus Filter">❌</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0 text-center align-middle">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Periode Penilaian</th>
                        <th>Skor</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->employee->nama_lengkap }}</td>
                            <td>{{ $review->period }}</td>
                            <td>{{ number_format($review->score, 2 )}}</td>
                            <td>
                                @if($review->status == 'Completed')
                                    <span class="badge bg-success fs-8 px-2 py-2 rounded-pill shadow-sm">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark fs-8 px-2 py-2 rounded-pill shadow-sm">In Progress</span>
                                @endif

                                
                            </td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('performance-reviews.show', $review->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('performance-reviews.edit', $review->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form id="delete-form-{{ $review->id }}" 
                                    action="{{ route('performance-reviews.destroy', $review->id) }}" method="POST" class="d-inline"> 
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(event, {{ $review->id }})">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

        <div class=" d-flex justify-content-end mt-3">
        {{-- Pastikan ini menggunakan withQueryString() untuk mempertahankan filter search --}}
        {{ $reviews->withQueryString()->links() }}
    </div>

@endsection


