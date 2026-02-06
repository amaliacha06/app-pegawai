<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request) // Terima objek Request
    {
        // 1. Ambil input pencarian dari URL (dari input name="search")
        $search = $request->input('search');

        // 2. Mulai query dasar (latest() untuk urutan terbaru)
        $positionsQuery = Position::latest();

        // 3. Cek apakah ada kata kunci pencarian
        if ($search) {
            // Jika ada, tambahkan kondisi WHERE
            // Mencari di kolom nama_lengkap, email, alamat, dan nomor_telepon
            $positionsQuery->where(function ($query) use ($search) {
                $query->where('nama_jabatan', 'like', '%' . $search . '%')
                      ->orWhere('gaji_pokok', 'like', '%' . $search . '%');
            });
        }
        // 4. Terapkan pagination ke query yang sudah difilter
        // Data yang difilter atau semua data akan di-paginate
        $positions = $positionsQuery->paginate(7);

        // 5. Kirim data ke view
        return view('position.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('position.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric',
        ]);

        Position::create($request->only(['nama_jabatan', 'gaji_pokok']));

        return redirect()->route('positions.index')
                ->with('success', ' Jabatan berhasil diTambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil satu data Jabatan berdasarkan ID.
        $position = Position::findOrFail($id);
        return view('position.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $position = Position::findOrFail($id);
        return view('position.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric',
        ]);

        $position = Position::findOrFail($id);
        $position->update($request->only(['nama_jabatan', 'gaji_pokok']));
    
        return redirect()->route('positions.index')
             ->with('success', 'Jabatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect()->route('positions.index')
                ->with('success', 'Jabatan berhasil diHapus!');
    }
}