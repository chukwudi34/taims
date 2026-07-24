<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Classes;
use App\Models\State as ModelsState;
use App\Models\StateLga;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class IndexController extends Controller
{
    public function home(Request $request)
    {
        // return Inertia::render('webpage/Index');
        return view('webpage.home');
    }

    public function test(Request $request)
    {
        // return Inertia::render('webpage/Index');
        return Inertia::render('test2');
    }

    public function user_type(Request $request)
    {
        // return Inertia::render('Webpage/Welcome');
        return view('webpage.welcome');
    }
    public function get_class()
    {
        $class = Classes::where('status', 'approved')->get();
        return $class;
    }

    public function get_state(Request $request)
    {
        return ModelsState::all();
    }

    public function get_state_lga(Request $request, $id)
    {
        return StateLga::where('state_id', $id)->get();
    }
}
