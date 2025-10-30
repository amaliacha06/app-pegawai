<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salaries extends Model
{
    protected $table = 'salaries';
    protected $fillable = [
        'karyawan_id',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'bulan',
        'total_gaji',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }
}