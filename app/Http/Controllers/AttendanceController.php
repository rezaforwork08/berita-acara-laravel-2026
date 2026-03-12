<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Attendance;
use \App\Models\Student;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::with('student')->latest()->get();
        $title = 'Data Attendance';
        return view('attendance.index', compact('attendances','title'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $students  = Student::get();
        return view('attendance.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
        ], [
            'attendances.required' => 'Silakan pilih minimal satu siswa untuk diabsen.',
        ]);

        $date = $request->date;
        $attendances = $request->attendances;

        foreach ($attendances as $attendanceData) {
            // Check if record exists for this date and student
            $existingAttendance = Attendance::where('student_id', $attendanceData['student_id'])
                                            ->whereDate('date', $date)
                                            ->first();

            if ($existingAttendance) {
                // Update existing record if needed or skip. Here we update.
                $existingAttendance->update([
                    'check_in' => $attendanceData['check_in'] ?? null,
                    'check_out' => $attendanceData['check_out'] ?? null,
                    'status_in' => $attendanceData['status_in'] ?? null,
                    'status_out' => $attendanceData['status_out'] ?? null,
                    'note' => $attendanceData['note'] ?? null,
                ]);
            } else {
                // Create new record
                Attendance::create([
                    'student_id' => $attendanceData['student_id'],
                    'date' => $date,
                    'check_in' => $attendanceData['check_in'] ?? null,
                    'check_out' => $attendanceData['check_out'] ?? null,
                    'status_in' => $attendanceData['status_in'] ?? null,
                    'status_out' => $attendanceData['status_out'] ?? null,
                    'note' => $attendanceData['note'] ?? null,
                ]);
            }
        }

        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
