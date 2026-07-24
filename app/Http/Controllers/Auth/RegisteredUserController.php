<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Models\LiveClass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Mail\NotifyNewStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'gender' => ['required'],
                'lga' => ['required'],
                'phone' => ['required'],
                'user_type' => ['required'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            if ($request->user_type == 'learner') {
                $request->validate([
                    'parent_email' => ['required', 'email', 'max:255', 'unique:users'],
                    'class_id' => ['required'],
                ]);
            }

            $user = new User();
            $user->fname = $request->firstname;
            $user->lname = $request->lastname;
            $user->user_type_id = $request->user_type == 'instructor' ? 1 : 2;
            $user->sex = $request->gender;
            $user->email = $request->email ?? null;
            $user->lga_id = $request->lga;
            $user->phone = $request->phone;
            $user->image = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyudBxqf1sdD2e3L4nI3nqsMt1_tceOyuZ7A&usqp=CAU';
            $user->password = Hash::make($request->password);
            $user->parent_email = $request->parent_email ?? null;
            $user->class_id = $request->class_id ?? null;
            $user->region = 'Africa/Lagos';
            $user->save();

            $live_class_for_class_student = LiveClass::where([
                'status' => 'ongoing',
                'class_id' => $user->class_id
            ])
                ->orWhere('status', 'not_started')
                ->first('meeting_url');

            if (!is_null($live_class_for_class_student)) {
                User::where('class_id', $user->class_id)
                    ->where('id', $user->id)
                    ->update(['meeting_url' => $live_class_for_class_student]);
                Mail::to($user->email)->send(new NotifyNewStudent($user->email));
            }

            Auth::login($user);

            event(new Registered($user));

            return response()->json([
                'message' => 'Registration successful',
                'user' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
