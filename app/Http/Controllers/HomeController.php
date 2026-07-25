<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\LiveClass;
use App\Models\RecordedVideo;
use App\Models\Quiz;
use App\Models\AttendanceRecord;
use App\Models\Transaction;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function index_v()
    {
        return Inertia::render('Auth/VerifyEmail');
    }

    public function analytic()
    {
        $user = Auth::user();

        if ($user->user_type_id === 3) {
            return $this->adminAnalytics();
        }

        if ($user->user_type_id === 1) {
            return $this->teacherAnalytics($user);
        }

        return $this->studentAnalytics($user);
    }

    private function adminAnalytics()
    {
        $total_teacher = User::where('user_type_id', 1)->count();
        $total_student = User::where('user_type_id', 2)->count();
        $total_users = User::count();
        $total_live_classes = LiveClass::count();
        $total_recorded_videos = RecordedVideo::count();
        $total_quizzes = Quiz::count();
        $total_transactions = Transaction::where('status', 'completed')->count();
        $total_revenue = Transaction::where('status', 'completed')->sum('amount');

        $usersByRole = [
            ['label' => 'Instructors', 'value' => $total_teacher],
            ['label' => 'Students', 'value' => $total_student],
            ['label' => 'Admins', 'value' => User::where('user_type_id', 3)->count()],
        ];

        $monthlyRegistrations = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return response()->json([
            'role' => 'admin',
            'stats' => [
                'total_teacher' => $total_teacher,
                'total_student' => $total_student,
                'total_users' => $total_users,
                'total_live_classes' => $total_live_classes,
                'total_recorded_videos' => $total_recorded_videos,
                'total_quizzes' => $total_quizzes,
                'total_transactions' => $total_transactions,
                'total_revenue' => number_format($total_revenue, 2),
            ],
            'charts' => [
                'users_by_role' => [
                    'labels' => array_column($usersByRole, 'label'),
                    'data' => array_column($usersByRole, 'value'),
                ],
                'monthly_registrations' => [
                    'labels' => $monthlyRegistrations->keys(),
                    'data' => $monthlyRegistrations->values(),
                ],
            ],
        ]);
    }

    private function teacherAnalytics($user)
    {
        $my_live_classes = LiveClass::where('created_by', $user->id)->count();
        $my_students = User::whereIn('class_id', LiveClass::where('created_by', $user->id)->pluck('class_id'))
            ->where('user_type_id', 2)->count();
        $my_recorded_videos = RecordedVideo::where('uploaded_by', $user->id)->count();
        $my_quizzes = Quiz::where('user_id', $user->id)->count();

        $liveClassStatus = LiveClass::where('created_by', $user->id)
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $monthlyLiveClasses = LiveClass::where('created_by', $user->id)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return response()->json([
            'role' => 'teacher',
            'stats' => [
                'my_live_classes' => $my_live_classes,
                'my_students' => $my_students,
                'my_recorded_videos' => $my_recorded_videos,
                'my_quizzes' => $my_quizzes,
            ],
            'charts' => [
                'live_class_status' => [
                    'labels' => $liveClassStatus->keys(),
                    'data' => $liveClassStatus->values(),
                ],
                'monthly_live_classes' => [
                    'labels' => $monthlyLiveClasses->keys(),
                    'data' => $monthlyLiveClasses->values(),
                ],
            ],
        ]);
    }

    private function studentAnalytics($user)
    {
        $my_purchases = Transaction::where('user_id', $user->id)
            ->where('status', 'completed')->count();

        $total_attendance = AttendanceRecord::where('student_id', $user->id)->count();
        $present_attendance = AttendanceRecord::where('student_id', $user->id)
            ->where('status', 'present')->count();
        $attendance_rate = $total_attendance > 0
            ? round(($present_attendance / $total_attendance) * 100) . '%'
            : '0%';

        $upcoming_live_classes = LiveClass::where('class_id', $user->class_id)
            ->where('status', 'not_started')
            ->where('date', '>=', now()->format('Y-m-d'))
            ->count();

        $attendanceBreakdown = AttendanceRecord::where('student_id', $user->id)
            ->selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        return response()->json([
            'role' => 'student',
            'stats' => [
                'my_purchases' => $my_purchases,
                'attendance_rate' => $attendance_rate,
                'total_attendance' => $total_attendance,
                'upcoming_live_classes' => $upcoming_live_classes,
            ],
            'charts' => [
                'attendance' => [
                    'labels' => $attendanceBreakdown->keys(),
                    'data' => $attendanceBreakdown->values(),
                ],
            ],
        ]);
    }
}
