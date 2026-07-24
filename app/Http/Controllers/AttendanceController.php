<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return Inertia::render('Attendance/Index');
    }
}
