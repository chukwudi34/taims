<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\LiveClass;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        $total_student = User::where('user_type_id','1')->count();
        $total_teacher = User::where('user_type_id','2')->count();
        $total_student_class = User::whereIn('class_id',Classes::pluck('id'))->count();
        $total_users = User::count();
        $live_class_for_teacher = LiveClass::where('created_by',Auth::user()->id)->count();
        $total_student_each_teacher = LiveClass::where('created_by',Auth::user()->id)->leftJoin('users','live_classes.class_id','users.class_id')->count();
        return response()->json(['live_class_for_teacher'=>$live_class_for_teacher,'total_users' => $total_users,'total_student_each_teacher' => $total_student_each_teacher,'total_teacher'=>$total_teacher,'total_student'=>$total_student,'total_student_class' =>$total_student_class]);
    }
}
