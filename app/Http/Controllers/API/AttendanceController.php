<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rfid_tag' => 'required|string',
            'timestamp' => 'required|date_format:Y-m-d\TH:i:s', // Expecting ISO 8601 format
        ]);

        $student = Student::where('rfid_tag', $validated['rfid_tag'])->first();

        if ($student) {
            $timestamp = Carbon::parse($validated['timestamp']);
        
            Attendance::create([
                'student_id' => $student->id,
                'date' => $timestamp->toDateString(),
                'time' => $timestamp->toTimeString(),
            ]);

            return response()->json(['message' => 'Attendance recorded'], 200);
        }

        return response()->json(['message' => 'Student not found'], 404);
    }
}
