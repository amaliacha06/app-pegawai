<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salaries;
class PerformanceReview extends Model
{
    use HasFactory;
    
    // Kolom-kolom yang diperbolehkan untuk diisi (mass assignment)
    protected $fillable = [
        'employee_id',
        'reviewer_id', 
        'period',
        'review_date',
        'score',
        'feedback',
        'training_recommendation',
        'status',
    ];

    
    // DEFINISI RELASI: Satu Penilaian Kinerja HANYA dimiliki oleh satu Pegawai.
    public function employee()
    {
        // Menghubungkan ke tabel 'employees' melalui Foreign Key 'employee_id'
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // RELASI TAMBAHAN: Siapa yang menilai pegawai ini (diambil dari tabel employees juga)
    public function reviewer()
    {
        // Menghubungkan ke tabel 'employees' melalui Foreign Key 'reviewer_id'
        return $this->belongsTo(Employee::class, 'reviewer_id');
        
    }
    public function salaries()
{
    // Menggunakan hasOne: Mengasumsikan satu review dikaitkan dengan satu data gaji tertentu.
    // Jika kolom foreign key di tabel 'salaries' adalah 'karyawan_id':
    return $this->hasOne(Salaries::class, 'karyawan_id', 'employee_id'); 
    // Foreign Key di Salaries: 'karyawan_id'
    // Local Key di PerformanceReview: 'employee_id' (sesuai relasi 'employee' Anda)
}
}