<?php

namespace App\Http\Controllers;

use App\Models\LiveClass;
use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->user_type_id == 2) {
            return Inertia::render('Attendance/StudentHistory');
        }

        if ($user->user_type_id == 3) {
            return Inertia::render('Attendance/AdminReport');
        }

        return Inertia::render('Attendance/Index');
    }

    public function showLiveClass($liveClassId)
    {
        $liveClass = LiveClass::with('subject', 'topic')->findOrFail($liveClassId);
        $students = User::where('class_id', $liveClass->class_id)
            ->where('user_type_id', 2)
            ->get(['id', 'fname', 'lname']);

        $existingRecords = AttendanceRecord::where('live_class_id', $liveClassId)
            ->get()
            ->keyBy('student_id');

        return response()->json([
            'liveClass' => $liveClass,
            'students' => $students->map(function ($student) use ($existingRecords) {
                return [
                    'id' => $student->id,
                    'name' => $student->fname . ' ' . $student->lname,
                    'status' => $existingRecords[$student->id]->status ?? null,
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'live_class_id' => 'required|exists:live_classes,id',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:users,id',
            'attendance.*.status' => 'required|in:present,absent,excused',
        ]);

        foreach ($request->attendance as $record) {
            AttendanceRecord::updateOrCreate(
                [
                    'live_class_id' => $request->live_class_id,
                    'student_id' => $record['student_id'],
                ],
                [
                    'status' => $record['status'],
                    'marked_by' => auth()->id(),
                ]
            );
        }

        return response()->json(['message' => 'Attendance saved successfully']);
    }

    public function studentHistory()
    {
        $records = AttendanceRecord::where('student_id', auth()->id())
            ->with('liveClass.subject', 'liveClass.topic')
            ->orderBy('created_at', 'desc')
            ->get();

        $total = $records->count();
        $present = $records->where('status', 'present')->count();
        $percentage = $total > 0 ? round(($present / $total) * 100) : 0;

        return response()->json([
            'records' => $records->map(function ($r) {
                return [
                    'date' => $r->created_at->format('Y-m-d'),
                    'topic' => $r->liveClass->topic->topic_name ?? 'N/A',
                    'subject' => $r->liveClass->subject->subject_name ?? 'N/A',
                    'status' => $r->status,
                ];
            }),
            'percentage' => $percentage,
        ]);
    }

    public function adminReport()
    {
        $records = AttendanceRecord::with('student', 'liveClass.subject', 'liveClass.topic')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('student_id');

        $report = $records->map(function ($studentRecords, $studentId) {
            $student = $studentRecords->first()->student;
            $total = $studentRecords->count();
            $present = $studentRecords->where('status', 'present')->count();
            $absent = $studentRecords->where('status', 'absent')->count();

            return [
                'student_name' => $student->fname . ' ' . $student->lname,
                'total_sessions' => $total,
                'present' => $present,
                'absent' => $absent,
                'percentage' => $total > 0 ? round(($present / $total) * 100) : 0,
            ];
        })->values();

        return response()->json(['report' => $report]);
    }
}
