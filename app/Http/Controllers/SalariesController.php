<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salaries;
use App\Models\Employee;

class SalariesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request) // Terima objek Request
    {
        // 1. Ambil input pencarian dari URL (dari input name="search")
        $search = $request->input('search');

        // Mulai dari semua data absensi dan langsung muat data karyawan (Eager Loading)
        $salariesQuery = Salaries::query()->with('employee')->latest();

        // 3. Cek apakah ada kata kunci pencarian
        if ($search) {
            // Gunakan whereHas untuk memfilter absensi berdasarkan kolom di tabel employee
            $salariesQuery->whereHas('employee', function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', '%' . $search . '%')
                      ->orWhere('bulan', 'like', '%' . $search . '%')
                      ->orWhere('gaji_pokok', 'like', '%' . $search . '%');
            });
        }
        $salaries = $salariesQuery->paginate(7);
        return view('salaries.index', compact('salaries'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all()->map(function($e){
            // try to find employee's position salary via jabatan_id or position_id
            $posId = $e->jabatan_id ?? $e->position_id ?? $e->jabatan_id ?? null;
            $gaji = 0;
            if ($posId) {
                $pos = \App\Models\Position::find($posId);
                if ($pos) $gaji = $pos->gaji_pokok;
            }
            $e->position_gaji = $gaji;
            return $e;
        });
        return view('salaries.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'gaji_pokok' => 'nullable|numeric',
            'tunjangan' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
            'bulan' => 'required|string|max:20',
        ]);

        $data = $request->only(['karyawan_id','gaji_pokok','tunjangan','potongan','bulan']);
        // if gaji_pokok not provided, try to use employee's position base salary
        if (empty($data['gaji_pokok'])) {
            $emp = Employee::find($data['karyawan_id']);
            $posId = $emp->jabatan_id ?? $emp->position_id ?? null;
            if ($posId) {
                $pos = \App\Models\Position::find($posId);
                $data['gaji_pokok'] = $pos->gaji_pokok ?? 0;
            } else {
                $data['gaji_pokok'] = 0;
            }
        }
        $data['tunjangan'] = $data['tunjangan'] ?? 0;
        $data['potongan'] = $data['potongan'] ?? 0;
        $data['total_gaji'] = ($data['gaji_pokok'] + $data['tunjangan']) - $data['potongan'];

        Salaries::create($data);

        return redirect()->route('salaries.index')
                ->with('success', 'Data Gaji berhasil diTambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salary = Salaries::with('employee')->findOrFail($id);
        return view('salaries.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salary = Salaries::findOrFail($id);
        $employees = Employee::all()->map(function($e){
            $posId = $e->jabatan_id ?? $e->position_id ?? null;
            $gaji = 0;
            if ($posId) {
                $pos = \App\Models\Position::find($posId);
                if ($pos) $gaji = $pos->gaji_pokok;
            }
            $e->position_gaji = $gaji;
            return $e;
        });
        return view('salaries.edit', compact('salary','employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'gaji_pokok' => 'nullable|numeric',
            'tunjangan' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
            'bulan' => 'required|string|max:20',
        ]);

        $salary = Salaries::findOrFail($id);
        $data = $request->only(['karyawan_id','gaji_pokok','tunjangan','potongan','bulan']);
        if (empty($data['gaji_pokok'])) {
            $emp = Employee::find($data['karyawan_id']);
            $posId = $emp->jabatan_id ?? $emp->position_id ?? null;
            if ($posId) {
                $pos = \App\Models\Position::find($posId);
                $data['gaji_pokok'] = $pos->gaji_pokok ?? 0;
            } else {
                $data['gaji_pokok'] = 0;
            }
        }
        $data['tunjangan'] = $data['tunjangan'] ?? 0;
        $data['potongan'] = $data['potongan'] ?? 0;
        $data['total_gaji'] = ($data['gaji_pokok'] + $data['tunjangan']) - $data['potongan'];

        $salary->update($data);

        return redirect()->route('salaries.index')
                ->with('success', 'Data Gaji berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salary = Salaries::findOrFail($id);
        $salary->delete();

        return redirect()->route('salaries.index')
            ->with('success', ' Data Gaji berhasil diHapus!');
    }
}