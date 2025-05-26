<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocailController extends Controller
{
    public function faqs()
    {
        try {
            $faqs = Faq::select('id', 'question', 'answer')->where('is_active', 1)->get();
            return response()->json([
                'status' => true,
                'Data' => $faqs,
                'Message' => 'Faqs fetched successfully'
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    "error" => $e->getMessage()
                ],
            );
        }
    }

    public function privacy()
    {
        try {
            $faqs = Content::select('id', 'name', 'description')->where('id', 1)->get();
            return response()->json([
                'status' => true,
                'Data' => $faqs,
                'Message' => 'Privacy Policy fetched successfully'
            ]);
        } catch (Exception $e) {
            return response()->json(
                [
                    "error" => $e->getMessage()
                ],
            );
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = auth()->user();
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'The current password is incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json(['message' => 'Password changed successfully'], 200);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ]);
        }
    }

    public function inquiries(Request $request)
    {
        $auth = auth()->user()->id;
        try {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
            ]);

            $inquiries = Inquiry::create([
                'user_id' => $auth,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'message' => $request->message,
                'seen' => 0,
            ]);
            $auth = auth()->user();
            $user = User::where('role', 'admin')->first();

            Notification::create([
                'user_id' => $auth->id,
                'message' => $auth->first_name . ' Has Contacted You ',
                'notifyBy' => 'admin Contact',
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Inquiry submitted successfully',
                'data' => $inquiries,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function adminDetail()
    {
        $adminDetail = User::select('phone', 'email')->where('role', 'admin')->get();
        return response()->json([
            'status' => true,
            'Data' => $adminDetail,
            'message' => 'Admin Detail Fetched successfully',
        ]);
    }

    public function deleteAccount()
    {
        try {
            $user = Auth::user();
            $user->delete();
            return response()->json(['message' => 'Account deleted successfully'], 200);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ]);
        }
    }
}
