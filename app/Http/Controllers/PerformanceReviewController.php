<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; // Pastikan Anda mengimpor Model Employee
use App\Models\PerformanceReview;


class PerformanceReviewController extends Controller
{
    // 1. INDEX: Menampilkan daftar semua Penilaian Kinerja

public function index(Request $request)
{
    $search = $request->input('search');
    // Eager Load 'employee' untuk menghindari N+1 problem di view
    $reviewsQuery = PerformanceReview::query()->with('employee')->latest();

    if ($search) {
        // Cukup gunakan whereHas() langsung, tidak perlu dibungkus where(function...
        $reviewsQuery->whereHas('employee', function ($query) use ($search) {
            
            // Mencari nama lengkap (pastikan Anda menggunakan LOWER() untuk mengatasi case sensitivity)
            $query->whereRaw('LOWER(nama_lengkap) LIKE ?', ['%' . strtolower($search) . '%']);
            
        });
        
        // ❗ Bagian orWhereHas('salaries', ...) sudah dihapus ❗
    }
    
    $reviews = $reviewsQuery->paginate(6);
    
    return view('performance_reviews.index', compact('reviews'));
}
    
   
    // 2. CREATE: Menampilkan formulir untuk membuat penilaian baru
    public function create()
    {
        // Ambil daftar semua pegawai untuk dipilih di form
        $employees = Employee::all(); 
        
        // Arahkan ke View 'performance_reviews/create.blade.php'
        return view('performance_reviews.create', compact('employees'));
    }

    // 3. STORE: Menyimpan data dari formulir 'create'
    public function store(Request $request)
    {
        // --- [VALIDASI DATA DI SINI] ---
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period' => 'required|string|max:50',
            'review_date' => 'required|date',
            'score' => 'required|numeric|min:0|max:100', // Asumsi skala 0-100
            'feedback' => 'required|string',
            // ... validasi kolom lain
        ]);
        
        // Simpan data baru ke database
        PerformanceReview::create($request->all());
          
        return redirect()->route('performance-reviews.index')
                         ->with('success', 'Penilaian Kinerja berhasil ditambahkan!');
    }

    // 4. SHOW: Menampilkan detail satu Penilaian Kinerja
    public function show(PerformanceReview $performanceReview)
    {
        // Arahkan ke View 'performance_reviews/show.blade.php'
        return view('performance_reviews.show', compact('performanceReview'));
    }

    // 5. EDIT: Menampilkan formulir untuk mengedit penilaian yang sudah ada
    public function edit(PerformanceReview $performanceReview)
    {
        $employees = Employee::all();
        // Arahkan ke View 'performance_reviews/edit.blade.php'
        return view('performance_reviews.edit', compact('performanceReview', 'employees'));
    }

    // 6. UPDATE: Menyimpan data yang diperbarui dari formulir 'edit'
    public function update(Request $request, PerformanceReview $performanceReview)
    {
        // --- [VALIDASI DATA DI SINI] ---
        // (Sama seperti di metode store)
         $request->validate([
            'employee_id' => 'required|exists:employees,id',
            
            // Perbaikan Aturan UNIQUE: Abaikan ID Review yang sedang diupdate
            'period' => 'required|string|max:50|unique:performance_reviews,period,'.$performanceReview->id.',id,employee_id,'.$performanceReview->employee_id,
            
            'review_date' => 'required|date',
            'score' => 'required|numeric|min:0|max:100', 
            'feedback' => 'required|string',
            'status' => 'required|in:In Progress,Completed'
        ]);
        
        $performanceReview->update($request->all());

        return redirect()->route('performance-reviews.index')
                         ->with('success', 'Penilaian Kinerja berhasil diperbarui!');
    }

    // 7. DESTROY: Menghapus satu Penilaian Kinerja
    public function destroy(PerformanceReview $performanceReview)
    {
        $performanceReview->delete();
        return redirect()->route('performance-reviews.index')
                         ->with('success', 'Penilaian Kinerja berhasil dihapus!');
    }
}