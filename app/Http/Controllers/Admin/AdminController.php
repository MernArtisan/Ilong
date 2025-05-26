<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function profile()
    {
        $admin = User::where('role', 'admin')->first();
        return view('admin.profile.index', compact('admin'));
    }
    public function profileUpdate(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->user()->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|min:6',
            'country' => 'required|string|max:255',
            'state_city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = auth()->user();
        $admin->first_name = $validated['first_name'];
        $admin->last_name = $validated['last_name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'];
        $admin->country = $validated['country'];
        $admin->state_city = $validated['state_city'];
        $admin->zip = $validated['zip'];
        if ($validated['password']) {
            $admin->password = Hash::make($validated['password']);
        }
        if ($request->hasFile('image')) {
            if ($admin->image && file_exists(public_path('profile_image/' . $admin->image))) {
                unlink(public_path('profile_image/' . $admin->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('profile_image'), $imageName);
            $admin->image = $imageName;
        }
        $admin->save();
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function superSearch(Request $request)
    {
        $query = $request->input('query');
    
        if ($query) {
            $users = User::where(function ($queryBuilder) use ($query) {
                    // Search based on first_name, last_name, or email
                    $queryBuilder->where('first_name', 'LIKE', "%{$query}%")
                        ->orWhere('last_name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%");
                })
                ->where(function ($statusBuilder) {
                    // Check if role is caregiver and status is pending OR
                    // role is professional and status is approved
                    $statusBuilder->where(function ($subQuery) {
                            $subQuery->where('role', 'caregiver')
                                     ->where('login_status', 'pending');
                        })
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('role', 'professional')
                                     ->where('login_status', 'approve');
                        });
                })
                ->get();
    
            // Ensure the correct asset URL for the profile image
            $users->transform(function ($user) {
                $user->profile_image_url = asset('profile_image/' . $user->image); // Using the 'image' field
                return $user;
            });
    
            return response()->json([
                'users' => $users
            ]);
        }
    
        return response()->json(['users' => []]); // Empty response if no query
    }
}
