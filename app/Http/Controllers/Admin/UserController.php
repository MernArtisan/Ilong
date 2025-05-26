<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $users = User::where('id', '!=', $user->id)->where('role', 'caregiver')->orderBy('id','desc')->get();
        return view('admin.user.index', compact('users'));
    }

    public function appRequest(Request $request)
    {
        $authId = auth()->user()->id;

        $users = User::where('id', '!=', $authId)
            ->where(function ($query) {
                $query->where('role', 'professional')
                    ->where('login_status', 'pending');
            })
            ->has('professionalProfile')
            ->with('professionalProfile')
            ->get();
        return view('admin.user.request', compact('users'));
    }



    public function requestShow($id)
    {
        if ($id) {
            $professional = User::with([
                'professionalBookings' => function ($query) {
                    $query->whereIn('status', ['accepted', 'completed', 'request', 'dispute', 'cancelled'])
                        ->orderBy('id', 'desc');
                },
                'professionalBookings.zoomMeeting',
                'professionalBookings.Bookingearnings',
                'professionalProfile',
                'licenses',
                'experiences',
            ])->find($id);
            return view('admin.user.requestShow', compact('professional'));
        }
    }

    public function show(string $id)
    {
        $user = User::with('childrens')->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        return view('admin.user.show', compact('user'));
    }


    public function create()
    {
        return view('admin.user.manage');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'country' => 'required|string|max:255',
            'state_city' => 'required|string|max:255',
            'image' => 'required|image',
        ]);
        $password = Str::random(8);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('profile_image'), $imageName);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'country' => $request->country,
            'role' => $request->role,
            'zip' => $request->zip,
            'age' => $request->age,
            'state_city' => $request->state_city,
            'image' => $imageName,
            'password' => bcrypt($password),
        ]);
        Mail::to($user->email)->send(new WelcomeEmail($user, $password));
        return redirect()->route('admin.customer.index')->with('success', 'Customer created successfully! And Password was sent successfully');
    }


    public function edit($id)
    {
        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.user.manage', compact('user'));
    }


    public function update(Request $request, $id)
    {
        // return "ebc";
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'country' => 'required|string|max:255',
            'state_city' => 'required|string|max:255',
            'image' => 'nullable|image', // optional image field
            'password' => 'nullable|string|min:8', // password is optional
            'role' => 'required|string', // Add role validation
            'zip' => 'required|string', // Add zip validation
            'age' => 'required|integer|min:18', // Add age validation
        ]);

        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Track if the password has been changed
        $passwordChanged = false;

        // If a password is provided, encrypt and update it
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $passwordChanged = true; // Mark that the password was changed
        }

        // Update the other fields
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->state_city = $request->state_city;
        $user->role = $request->role;  // Fix: Assign role
        $user->zip = $request->zip;    // Fix: Assign zip
        $user->age = $request->age;    // Fix: Assign age

        // Handle the image upload (if a new image is uploaded)
        if ($request->hasFile('image')) {
            // Delete old image if exists (optional)
            if ($user->image && file_exists(public_path('profile_image/' . $user->image))) {
                unlink(public_path('profile_image/' . $user->image));
            }

            // Generate a new image name and move it to the storage path
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('profile_image'), $imageName);
            $user->image = $imageName; // Update the user's image
        }

        // Save the updated user data
        $user->save();

        // If the password was changed, send an email notification
        if ($passwordChanged) {
            $password = $request->password;  // Send the new password
            Mail::to($user->email)->send(new WelcomeEmail($user, $password)); // Send the password email
        }

        // Redirect back with a success message
        return redirect()->route('admin.customer.index')->with('success', 'User updated successfully!');
    }




    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }


    public function Contacts(Request $request)
    {
        $contact = Inquiry::orderBy('id','desc')->get();
        return view('admin.contacts.index', compact('contact'));
    }

    public function contactShow($id)
    {
        $contact = Inquiry::find($id);

        if (!$contact) {
            return redirect()->route('admin.contacts.index')->with('error', 'Contact not found.');
        }
        Inquiry::where('id', $id)
            ->update(['seen' => 1]);
        return view('admin.contacts.show', compact('contact'));
    }
}
