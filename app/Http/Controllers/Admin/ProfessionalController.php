<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserApproved;
use App\Mail\UserRejected;
use App\Mail\WelcomeEmail;
use App\Models\Experience;
use App\Models\License;
use App\Models\ProfessionalEarning;
use App\Models\ProfessionalProfile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProfessionalController extends Controller
{
    public function index()
    {
        $professionals = User::where('role', '!=', 'admin')->where('role', 'professional')->where('login_status', 'approve')->orderBy('id', 'desc')->get();
        return view('admin.professional.index', compact('professionals'));
    }

    public function create()
    {
        return view('admin.professional.create');
    }


    public function store(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $this->validateRequest($request);
            $password = $request->password;

            // Send a welcome email
            Mail::to($request->email)->send(new WelcomeEmail($request, $password));

            // Process images and store them
            $imagePath = $this->processImage($request, 'image', 'profile_image');
            $credentialsPath = $this->processImage($request, 'credentials', 'credentials');

            // Create or update user
            $user = $this->createOrUpdateUser(null, $validatedData, $imagePath); // null for new user

            // Create professional profile for the user
            $this->createProfessionalProfile($user, $validatedData, $credentialsPath);

            // Create work experience if provided
            if (isset($validatedData['work_experience'])) {
                $this->createWorkExperience($user, $validatedData['work_experience']);
            }

            // Create licenses if provided
            if (isset($validatedData['licenses'])) {
                $this->createLicenses($user, $validatedData['licenses']);
            }

            return redirect()->route('admin.professionals.index')->with('success', 'Professional and profile created successfully!');
        } catch (Exception $e) {
            return redirect()->route('admin.professionals.create')->with('error', 'An error occurred while creating the user profile.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $this->validateRequest($request);

            $user = User::findOrFail($id);

            if ($request->filled('password')) {
                $password = $request->password;
                Mail::to($request->email)->send(new WelcomeEmail($request, $password));
            }

            $userImage = $user->image;
            $userCredentials = $user->professionalProfile->credentials;
            $imagePath = $this->processImage($request, 'image', 'profile_image', $userImage);
            $credentialsPath = $this->processImage($request, 'credentials', 'credentials', $userCredentials);

            $this->createOrUpdateUser($user, $validatedData, $imagePath);
            $this->createProfessionalProfile($user, $validatedData, $credentialsPath);

            if (isset($validatedData['work_experience'])) {
                $this->createWorkExperience($user, $validatedData['work_experience']);
            }

            if (isset($validatedData['licenses'])) {
                $this->createLicenses($user, $validatedData['licenses']);
            }

            return redirect()->route('admin.professionals.index')->with('success', 'Professional and profile updated successfully!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('admin.professionals.edit', $id)->with('error', 'An error occurred while updating the user profile.');
        }
    }



    private function createOrUpdateUser($user, $validatedData, $imagePath)
    {
        if ($user) {
            // Update existing user
            $user->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'country' => $validatedData['country'],
                'state_city' => $validatedData['state_city'],
                'role' => $validatedData['role'],
                'age' => $validatedData['age'],
                'zip' => $validatedData['zip'],
                'phone' => $validatedData['phone'],
                'image' => $imagePath,
            ]);
            return $user;
        } else {
            // Create a new user
            return User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'country' => $validatedData['country'],
                'state_city' => $validatedData['state_city'],
                'role' => $validatedData['role'],
                'age' => $validatedData['age'],
                'zip' => $validatedData['zip'],
                'phone' => $validatedData['phone'],
                'login_status' => 'approve',
                'image' => $imagePath,
            ]);
        }
    }

    private function createProfessionalProfile($user, $validatedData, $credentialsPath)
    {
        // Create or update the professional profile for the user
        ProfessionalProfile::updateOrCreate(
            ['user_id' => $user->id], // Check if profile exists for the user
            [
                'professional_field' => $validatedData['professional_field'],
                'education_degrees' => $validatedData['education_degrees'],
                'certifications' => $validatedData['certifications'],
                'skills' => json_encode(array_map('trim', explode(',', $validatedData['skills']))),
                'languages' => json_encode(array_map('trim', explode(',', $validatedData['languages']))),
                'practice' => json_encode(array_map('trim', explode(',', $validatedData['practice']))),
                'hour_rate' => $validatedData['hour_rate'],
                'about' => $validatedData['about'],
                'website' => $validatedData['website'],
                'credentials' => $credentialsPath,
            ]
        );
    }

    private function createWorkExperience($user, $workExperiences)
    {
        Experience::where('user_id', $user->id)->delete();
        foreach ($workExperiences as $experience) {
            Experience::create([
                'user_id' => $user->id,
                'job_title' => $experience['job_title'],
                'company_name' => $experience['company_name'],
                'from' => $experience['from'],
                'to' => $experience['to'],
            ]);
        }
    }


    private function createLicenses($user, $licenses)
    {
        License::where('user_id', $user->id)->delete();
        foreach ($licenses as $license) {
            License::create([
                'user_id' => $user->id,
                'license_name' => $license['license_name'],
                'license_id' => $license['license_id'],
                'from' => $license['from'],
                'to' => $license['to'],
            ]);
        }
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:4',
            'phone' => 'required|string|min:10',
            'country' => 'required|string|max:255',
            'state_city' => 'required|string|max:255',
            'role' => 'required|in:caregiver,professional',
            'age' => 'nullable|integer|min:18',
            'zip' => 'nullable|string|max:10',
            'image' => 'nullable|image',
            'credentials' => 'nullable|image',
            'professional_field' => 'required|string|max:255',
            'education_degrees' => 'required|string|max:255',
            'certifications' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'languages' => 'required|string|max:255',
            'practice' => 'required|string|max:255',
            'hour_rate' => 'required|numeric',
            'about' => 'nullable|string',
            'website' => 'nullable|string|url',
            'work_experience' => 'array',
            'work_experience.*.job_title' => 'nullable|string',
            'work_experience.*.company_name' => 'nullable|string',
            'work_experience.*.from' => 'nullable|date',
            'work_experience.*.to' => 'nullable|date',
            'licenses' => 'nullable|array', // Allow licenses to be optional
            'licenses.*.license_name' => 'nullable|string',
            'licenses.*.license_id' => 'nullable|string',
            'licenses.*.from' => 'nullable|date',
            'licenses.*.to' => 'nullable|date',
        ]);
    }

    private function processImage(Request $request, $fileInputName, $directory, $oldImage = null)
    {
        // Check if a file was uploaded
        if ($request->hasFile($fileInputName)) {
            // Get the original image name
            $imagePath = $request->file($fileInputName)->getClientOriginalName();

            // Check if the file already exists
            $destinationPath = public_path($directory);
            $existingFile = $destinationPath . '/' . $imagePath;

            // If file exists, return the existing file path, otherwise save the new file
            if (file_exists($existingFile)) {
                return $imagePath;
            } else {
                $request->file($fileInputName)->move($destinationPath, $imagePath);
                return $imagePath;
            }
        } else {
            // If no file is uploaded, return the old image path if available
            return $oldImage;
        }
    }



    public function edit($id)
    {
        $professional = User::with([
            'professionalBookings' => function ($query) {
                $query->orderBy('id', 'desc');
            },
            'professionalBookings.zoomMeeting',
            'professionalBookings.Bookingearnings',
            'professionalProfile',
            'licenses',
            'experiences',
        ])->find($id);

        return view('admin.professional.edit', compact('professional'));
    }
    public function show($id)
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

            if ($professional) {
                $acceptedBookings = $professional->professionalBookings->where('status', 'accepted');
                $completedBookings = $professional->professionalBookings->where('status', 'completed');
                $pendingBookings = $professional->professionalBookings->where('status', 'request');
                $disputedBookings = $professional->professionalBookings->where('status', 'dispute');
                $cancelledBookings = $professional->professionalBookings->where('status', 'cancelled');

                $totalEarnings = $professional->professionalBookings->map(function ($booking) {
                    return $booking->Bookingearnings ? $booking->Bookingearnings->earning_amount : 0;
                })->sum();

                $nurturenestProfit = $totalEarnings * 0.09;
                $finalEarnings = $totalEarnings - $nurturenestProfit;

                $paidEarnings = $professional->professionalBookings->map(function ($booking) {
                    return $booking->Bookingearnings && $booking->Bookingearnings->status === 'paid'
                        ? $booking->Bookingearnings->earning_amount
                        : 0;
                })->sum();

                $paidEarningsAfterProfit = $paidEarnings - ($paidEarnings * 0.09);

                return view('admin.professional.show', compact(
                    'professional',
                    'acceptedBookings',
                    'completedBookings',
                    'pendingBookings',
                    'disputedBookings',
                    'cancelledBookings',
                    'totalEarnings',
                    'nurturenestProfit',
                    'finalEarnings',
                    'paidEarnings',
                    'paidEarningsAfterProfit'
                ));
            } else {
                return redirect()->route('admin.professionals.index');
            }
        } else {
            return redirect()->route('admin.professionals.index');
        }
    }
    public function updateEarningStatus($id)
    {
        $earning = ProfessionalEarning::find($id);

        if ($earning) {
            $earning->status = 'paid';
            $earning->save();

            return redirect()->back()->with('success', 'Earning status updated to Paid');
        }
        return redirect()->back()->with('error', 'Earning not found');
    }
    public function changeStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (in_array($request->status, ['approve', 'reject', 'pending', 'block'])) {
            $user->login_status = $request->status;

            if ($request->status == 'reject') {
                // Send rejection email before deleting the user account
                Mail::to($user->email)->send(new UserRejected($user));  // Assuming you have a UserRejected mail class

                $user->delete();  // Delete the account after sending the email

                return response()->json(['success' => true, 'message' => 'User rejected, email sent, and account deleted']);
            } elseif ($request->status == 'approve') {
                $user->save();
                Mail::to($user->email)->send(new UserApproved($user));  // Send approval email
                return response()->json(['success' => true, 'message' => 'User approved and email sent']);
            } else {
                $user->save();
                return response()->json(['success' => true, 'message' => 'Status updated']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid status']);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Professional deleted successfully.');
    }
}
