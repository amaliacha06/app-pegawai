<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Salaries;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::with('employee')->latest()->paginate(15);
        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'status_absensi' => 'required|string|max:50',
        ]);

        $attendance = Attendance::create($request->only(['karyawan_id','tanggal','waktu_masuk','waktu_keluar','status_absensi']));

        // Update salary total when attendance indicates presence
        $this->applyAttendanceToSalary($attendance);

        return redirect()->route('attendance.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('attendance.edit', compact('attendance','employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i',
            'status_absensi' => 'required|string|max:50',
        ]);

        $attendance = Attendance::findOrFail($id);
        // capture original values to avoid double counting
        $oldStatus = $attendance->status_absensi;
        $oldTanggal = $attendance->tanggal;

        $attendance->update($request->only(['karyawan_id','tanggal','waktu_masuk','waktu_keluar','status_absensi']));

        // Apply salary adjustment based on the delta between old and new attendance
        $this->applyAttendanceToSalary($attendance, $oldStatus, $oldTanggal);

        return redirect()->route('attendance.index');
    }

    /**
     * Apply attendance effects to the employee's salary for the attendance month.
     * Rule (default): when status_absensi == 'hadir', add per-day pay to salaries.total_gaji.
     * Per-day pay is calculated as position.gaji_pokok / WORK_DAYS_PER_MONTH (default 22).
     */
    protected function applyAttendanceToSalary(Attendance $attendance, $oldStatus = null, $oldTanggal = null)
    {
        $newStatus = strtolower($attendance->status_absensi ?? '');
        $oldStatusNorm = $oldStatus ? strtolower($oldStatus) : null;

        $employee = Employee::find($attendance->karyawan_id);
        if (! $employee) return;

        // helper to compute per-day based on employee's position
        $computePerDay = function($emp) {
            $posId = $emp->jabatan_id ?? $emp->position_id ?? null;
            if (! $posId) return 0;
            $pos = \App\Models\Position::find($posId);
            if (! $pos || ! isset($pos->gaji_pokok)) return 0;
            $workDays = 22; // default working days per month
            return floatval($pos->gaji_pokok) / $workDays;
        };

        // determine bulan keys
        $newBulan = $attendance->tanggal ? date('Y-m', strtotime($attendance->tanggal)) : null;
        $oldBulan = $oldTanggal ? date('Y-m', strtotime($oldTanggal)) : null;

        // Cases:
        // 1) creation: oldStatus == null -> if newStatus == 'hadir' add perDay to newBulan
        // 2) update: handle transitions between hadir <-> non-hadir and month moves

        // add per-day to given bulan
        $addPerDayToMonth = function($emp, $bulan) use ($computePerDay) {
            if (! $bulan) return;
            $perDay = $computePerDay($emp);
            if ($perDay <= 0) return;
            $salary = Salaries::where('karyawan_id', $emp->id)->where('bulan', $bulan)->first();
            if (! $salary) {
                // create minimal salary record
                $posId = $emp->jabatan_id ?? $emp->position_id ?? null;
                $pos = $posId ? \App\Models\Position::find($posId) : null;
                Salaries::create([
                    'karyawan_id' => $emp->id,
                    'bulan' => $bulan,
                    'gaji_pokok' => $pos->gaji_pokok ?? 0,
                    'tunjangan' => 0,
                    'potongan' => 0,
                    'total_gaji' => $perDay,
                ]);
            } else {
                $salary->total_gaji = $salary->total_gaji + $perDay;
                $salary->save();
            }
        };

        // subtract per-day from given bulan (if record exists)
        $subtractPerDayFromMonth = function($emp, $bulan) use ($computePerDay) {
            if (! $bulan) return;
            $perDay = $computePerDay($emp);
            if ($perDay <= 0) return;
            $salary = Salaries::where('karyawan_id', $emp->id)->where('bulan', $bulan)->first();
            if (! $salary) return;
            $salary->total_gaji = max(0, $salary->total_gaji - $perDay);
            $salary->save();
        };

        if (is_null($oldStatus)) {
            // creation path
            if ($newStatus === 'hadir') {
                $addPerDayToMonth($employee, $newBulan);
            }
            return;
        }

        // update path
        if ($oldStatusNorm !== 'hadir' && $newStatus === 'hadir') {
            // became hadir -> add to new month
            $addPerDayToMonth($employee, $newBulan);
            return;
        }

        if ($oldStatusNorm === 'hadir' && $newStatus !== 'hadir') {
            // was hadir before, now not -> subtract from old month
            $subtractPerDayFromMonth($employee, $oldBulan);
            return;
        }

        if ($oldStatusNorm === 'hadir' && $newStatus === 'hadir') {
            // still hadir; if date/month changed move the per-day
            if ($oldBulan && $newBulan && $oldBulan !== $newBulan) {
                $subtractPerDayFromMonth($employee, $oldBulan);
                $addPerDayToMonth($employee, $newBulan);
            }
            // otherwise nothing to change
            return;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $attendance = Attendance::findOrFail($id);
        // if this attendance was 'hadir', subtract its per-day from the month's salary
        if (strtolower($attendance->status_absensi) === 'hadir') {
            $employee = Employee::find($attendance->karyawan_id);
            if ($employee) {
                $bulan = $attendance->tanggal ? date('Y-m', strtotime($attendance->tanggal)) : null;
                $posId = $employee->jabatan_id ?? $employee->position_id ?? null;
                if ($posId) {
                    $pos = \App\Models\Position::find($posId);
                    if ($pos && isset($pos->gaji_pokok) && $bulan) {
                        $perDay = floatval($pos->gaji_pokok) / 22;
                        $salary = Salaries::where('karyawan_id', $employee->id)->where('bulan', $bulan)->first();
                        if ($salary) {
                            $salary->total_gaji = max(0, $salary->total_gaji - $perDay);
                            $salary->save();
                        }
                    }
                }
            }
        }
        $attendance->delete();
        return redirect()->route('attendance.index');
    }
}