<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendForgotPasswordOTP;
use App\Models\Children;
use App\Models\ProfessionalProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'role' => 'required|string|in:caregiver,professional',
                'phone' => 'nullable|string|min:10|max:15',
                'zip' => 'nullable|digits:5',
                'state_city' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $loginStatus = $request->role == 'caregiver' ? 'approve' : 'pending';

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone' => $request->phone,
                'zip' => $request->zip,
                'state_city' => $request->state_city,
                'country' => $request->country,
                'login_status' => $loginStatus, 
            ]);

            if ($request->role == 'caregiver') {
                return response()->json([
                    'status' => 200,
                    'message' => 'Caregiver registered successfully!',
                    'data' => $user,
                ],  200);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Professional registered successfully!',
                    'data' => $user,
                ],  200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while registering the user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'fcm_token' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // Update FCM token
        $user->fcm_token = $request->fcm_token;
        $user->save();

        // Check if Children and Professional profiles exist
        $ChildrenAdded = Children::where('caregiver_id', $user->id)->exists();
        $ProfessionalAdded = ProfessionalProfile::where('user_id', $user->id)->exists();

        // Check if user is blocked
        if ($user->login_status == 'block') {
            return response()->json([
                'status' => false,
                'message' => 'Your account has been blocked.'
            ], 401);
        }
 
        $user->image = $user->image 
        ? asset('profile_image/' . $user->image) 
        : asset('default.png');
        $user->cover_image = $user->cover_image 
        ? asset('profile_image/' . $user->cover_image) 
        : asset('default.png'); 


        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Login successful!',
            'token' => $token,
            'children' => $ChildrenAdded,
            'professional' => $ProfessionalAdded,
            'data' => $user,
        ], 200);
    }




    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $requestedUser = User::where('email', $request->email)->first();
    
        if ($requestedUser) {
            if ($requestedUser->role === 'professional' && $requestedUser->login_status === 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is not approved yet.',
                ], 401);
            }
        }
    
        // $UserExists = DB::table('password_reset_tokens')->where('email', '=', $request->email)->first();
    
        // if ($UserExists) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'A password reset request has already been sent to this email.'
        //     ], 409);
        // }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found with this email.'
            ], 404);
        }
    
        // Generate OTP
        $otp = rand(1000, 9999);
    
        DB::table('password_reset_tokens')->updateOrInsert([
            'email' => $request->email
        ], [
            'token' => $otp,
            'created_at' => now(),
        ]);
    
    //    Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($request) {
    //     $message->to($request->email)
    //                 ->subject('Password Reset OTP');
    //     });
    
        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your registered email.',
            'email' => $request->email,
            'otp' => $otp,
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $otpCheck = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->otp,
        ])->first();
        if (!$otpCheck) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully!',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'User not found with this email.'
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully!',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User logged out successfully!'
        ]);
    }
}
