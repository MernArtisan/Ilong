<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');  // Yahan 'admin.login' aapke login page ka view hona chahiye
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only('email'));
        }

        // Attempt to authenticate using the 'admin' guard
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            // Get the authenticated user
            $user = Auth::guard('admin')->user();

            // Check if the user's role is 'admin'
            if ($user->role !== 'admin') {
                // Logout the user if they are not an admin
                Auth::guard('admin')->logout();
                return redirect()->back()->with('error', 'You are not authorized to access this page.');
            }

            // If the role is 'admin', proceed to the admin dashboard
            return redirect()->route('admin.dashboard')->with('success', 'Login successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid Email or Password');
        }
    }
}
