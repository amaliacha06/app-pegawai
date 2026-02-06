<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Terima objek Request
    {
        // 1. Ambil input pencarian dari URL (dari input name="search")
        $search = $request->input('search');
        // 2. Mulai query dasar (latest() untuk urutan terbaru)
        $employeesQuery = Employee::latest();
        // 3. Cek apakah ada kata kunci pencarian
        if ($search) {
            // Jika ada, tambahkan kondisi WHERE
            // Mencari di kolom nama_lengkap, email, alamat, dan nomor_telepon
            $employeesQuery->where(function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('alamat', 'like', '%' . $search . '%')
                      ->orWhere('nomor_telepon', 'like', '%' . $search . '%');
                // Tambahkan kolom lain jika diperlukan
            });
        }
        // 4. Terapkan pagination ke query yang sudah difilter
        // Data yang difilter atau semua data akan di-paginate
        $employees = $employeesQuery->paginate(5);
        // 5. Kirim data ke view
        return view('employee.index', compact('employees'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employee.create', compact('departments', 'positions'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // Tambahkan unique untuk email agar tidak ada duplikasi
            'email' => 'required|email|max:255|unique:employees,email', 
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
            'status' => 'required|string|max:50',
        ]);
        
        // Menggunakan $request->all() lebih ringkas jika semua field form sesuai fillable di Model
        Employee::create($request->all()); 

        return redirect()->route('employees.index')
                    ->with('success', 'Data Pegawai berhasil ditambahkan!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $employee = Employee::find($id);
        // Pertimbangkan menggunakan findOrFail() untuk penanganan 404 yang lebih baik
        return view('employee.show', compact('employee'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        // Gunakan findOrFail untuk memastikan pegawai ada
        $employee = Employee::findOrFail($id); 
        $departments = Department::all();
        $positions = Position::all();
        return view('employee.edit', compact('employee', 'departments', 'positions'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        // Ambil data pegawai yang akan diupdate
        $employee = Employee::findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // Abaikan email pegawai saat ini dari pemeriksaan unique
            'email' => 'required|email|max:255|unique:employees,email,' . $employee->id, 
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
            'status' => 'required|string|max:50',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Data Pegawai berhasil diperbarui!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // Gunakan findOrFail untuk memastikan pegawai ada
        $employee = Employee::findOrFail($id); 
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Data Pegawai berhasil diHapus!');
    }
}