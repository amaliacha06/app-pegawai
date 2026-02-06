<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartemensController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request) // Terima objek Request
    {
        // 1. Ambil input pencarian dari URL (dari input name="search")
        $search = $request->input('search');

        // 2. Mulai query dasar (latest() untuk urutan terbaru)
        $departmentsQuery = Department::latest();

        // 3. Cek apakah ada kata kunci pencarian
        if ($search) {
            // Jika ada, tambahkan kondisi WHERE
            // Mencari di kolom nama_lengkap, email, alamat, dan nomor_telepon
            $departmentsQuery->where(function ($query) use ($search) {
                $query->where('nama_departemen', 'like', '%' . $search . '%');
            });
        }
        // 4. Terapkan pagination ke query yang sudah difilter
        // Data yang difilter atau semua data akan di-paginate
        $departments = $departmentsQuery->paginate(7);

        // 5. Kirim data ke view
        return view('departements.index', compact('departments'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        Department::create($request->only(['nama_departemen']));

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $department = Department::findOrFail($id);
        return view('departements.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $department = Department::findOrFail($id);
        return view('departements.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->only(['nama_departemen']));

        return redirect()->route('departments.index')
            ->with('success', ' Departemen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil diHapus!');
    }
}