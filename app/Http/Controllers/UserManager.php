<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserManager extends Controller
{
    // admin

    public function index()
    {
        return Inertia::render('UserManager/Admin/Index');
    }

    public function All(Request $request)
    {
        //    dd($request);
        // $admin_data = User::paginate();
        $admin_data = User::whereIn('user_type_id',[1,2,5]);
        if ($request->has('filters.search')) {
            if (!is_null($request->input('filters.search'))) {
                $admin_data = User::where('fname', 'LIKE', '%' . $request->input('filters.search') . '%')
                    ->orWhere('lname', 'LIKE', '%' . $request->input('filters.search') . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->input('filters.search') . '%')
                    ->paginate(10);
            }
        }
        return $admin_data->paginate(10);

        // return response()->json(['data' => $admin_data->paginate(1), 'status' => 200]);
    }

    public function Update(Request $request)
    {
        // dd($request);
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
        ]);
        $update_client = User::where('id', $request->id)->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'company_name' => $request->company_name,
            'email' => $request->email
        ]);
        if ($update_client) return response()->json(['msg' => 'updated successfully', 'status' => 200]);
    }
    public function Status(Request $request)
    {
        // dd($request);
        $update_client_status = User::where('id', $request->id)->update([
            'status' => $request->status,
        ]);
        if ($update_client_status) return response()->json(['msg' => 'status updated successfully', 'status' => 200]);
    }
    public function Remove(Request $request)
    {
        $delete = User::where('id', $request->id)->delete();
        if ($delete) return response()->json(['msg' => 'Deleted updated successfully', 'status' => 200]);
    }


    public function resetAdminPassword(Request $request)
    {
        //    dd($request);

        $user = User::where('id', $request->id)->first();
        $user_lname = $user->lname;

        $reset_password = $user->update([
            'password' => bcrypt($user_lname)
        ]);
        if ($reset_password) return response()->json(['msg' => 'password resetted successfully', 'status' => 200]);
    }

    public function RemoveFromAdmin(Request $request)
    {
        //    dd($request);
        $update_role = User::where('id', $request->id)->update([
            'user_type_id' => $request->user_type_id
        ]);
        if ($update_role) return response()->json(['msg' => 'Role Set successfully', 'status' => 200]);
    }
}
