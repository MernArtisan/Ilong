<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    public function childrenProfile(Request $request)
    {
        try {
            // Validate the request for a single child
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'age' => 'required|integer|min:0|max:18',
                'gender' => 'required|string|in:male,female,other',
                'concern' => 'nullable|array', // Concern can be an array
                'concern.*' => 'nullable|string|max:255', // Each concern should be a string
                'interests' => 'nullable|array', // Interests can be an array
                'interests.*' => 'nullable|string|max:255', // Each interest should be a string
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Single file upload validation
                'description' => 'required|string',
            ]);

            // Get the caregiver's user ID
            $userId = auth()->user()->id;

            // Handle the image upload if a file is provided
            $imagePath = null;
            if ($request->hasFile('image')) {
                // Get the uploaded image
                $image = $request->file('image');

                // Generate a unique filename
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Save the image to the public/ChildrenProfile folder
                $image->move(public_path('ChildrenProfile'), $imageName);

                // Set the image path
                $imagePath = $imageName;
            }

            // Create the child data
            $childData = [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'age' => $validatedData['age'],
                'gender' => $validatedData['gender'],
                'concern' => $validatedData['concern'] ?? [], // Concern as an array
                'interests' => $validatedData['interests'] ?? [], // Interests as an array
                'image' => $imagePath, // Store the image path
                'caregiver_id' => $userId, // Store caregiver's ID
            ];

            // Create the child in the database
            $createdChild = Children::create($childData);

            // Prepare the response with just name and caregiver_id
            $responseData = [
                'name' => $createdChild->name,
                'caregiver_id' => $createdChild->caregiver_id,
            ];

            // Return a successful response with the created child's name and caregiver ID
            return response()->json([
                'status' => 200,
                'data' => ['child' => $responseData],
                'message' => 'Child created successfully',
            ], 201);
        } catch (\Exception $e) {
            // Return the exception message for debugging in case of an error
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function Authprofile()
    {
        $auth = auth()->user();
        $profile = User::where('id', $auth->id)->first();

        return response()->json([
            'status' => true,
            'profile' => $profile
        ]);
    }

    public function AuthUpdateProfile(Request $request)
    {
        try {
            $auth = auth()->user();
            $updateData = $request->only(['first_name', 'last_name', 'name', 'email']); // Explicitly mention the fields you want to update

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $auth->id . '_profile.' . $image->getClientOriginalExtension();
                $image->move(public_path('profile_image'), $imageName);
                $updateData['image'] = $imageName;
            }

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $cover_image = $request->file('cover_image');
                $cover_imageName = time() . '_' . $auth->id . '_cover.' . $cover_image->getClientOriginalExtension();
                $cover_image->move(public_path('profile_image'), $cover_imageName);
                $updateData['cover_image'] = $cover_imageName;
            }

            // Update user profile with new data
            $auth->update($updateData);

            // Prepare the full URLs for profile image and cover image
            $profileImageUrl = $auth->image ? asset('profile_image/' . $auth->image) : null;
            $coverImageUrl = $auth->cover_image ? asset('profile_image/' . $auth->cover_image) : null;

            return response()->json([
                'status' => true,
                'user' => [
                    'id' => $auth->id,
                    'first_name' => $auth->first_name,  // Include first_name in response
                    'last_name' => $auth->last_name,    // Include last_name in response
                    'email' => $auth->email,
                    'image' => $profileImageUrl,
                    'cover_image' => $coverImageUrl,
                ],
                'message' => 'Profile updated successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }






    public function ProffessionalProfileUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'age' => 'required|integer',
                // 'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'professional_field' => 'required|string|max:255',
                'education_degrees' => 'required|string',
                'certifications' => 'required|string',
                // 'credentials' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'skills' => 'required|array',
                'skills.*' => 'string|max:255',
                'practice' => 'required|array',
                'practice.*' => 'string|max:255',
                'languages' => 'required|array',
                'languages.*' => 'string|max:255',
                'website' => 'required|url',
                'about' => 'required|string|max:1000',
                'hour_rate' => 'required',
                'experience' => 'required|array',
                'experience.*.job_title' => 'required|string|max:255',
                'experience.*.company_name' => 'required|string|max:255',
                'experience.*.from' => 'required|date',
                'experience.*.to' => 'required|date',
                'license' => 'required|array',
                'license.*.license_name' => 'required|string|max:255',
                'license.*.license_id' => 'required|string|max:255',
                'license.*.from' => 'required|date',
                'license.*.to' => 'required|date',
                'license.*.license_image' => 'nullable|file|mimes:jpg,png,pdf',
            ]);

            $user = auth()->user();
            $user->update([
                'first_name' => $request->first_name,
                'age' => $request->age,
            ]);
            // if ($request->hasFile('image')) {
            //     $imageFile = $request->file('image');
            //     $imageName = time() . '_' . $user->id . '.' . $imageFile->getClientOriginalExtension();
            //     $imageFile->move(public_path('profile_image'), $imageName);
            //     $user->update(['image' => $imageName]);
            // }
            $profile = $user->professionalProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'professional_field' => $request->professional_field,
                    'education_degrees' => $request->education_degrees,
                    'certifications' => $request->certifications,
                    'skills' => json_encode($request->skills),
                    'languages' => json_encode($request->languages),
                    'practice' => json_encode($request->practice),
                    'website' => $request->website,
                    'about' => $request->about,
                    'hour_rate' => $request->hour_rate,
                ]
            );
            // if ($request->hasFile('credentials')) {
            //     $file = $request->file('credentials');
            //     $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('credentials'), $fileName);
            //     $profile->credentials = $fileName;
            //     $profile->save();
            // }
            if ($request->has('experience')) {
                $experiences = collect($request->experience)->map(function ($exp) use ($user) {
                    return [
                        'user_id' => $user->id,
                        'job_title' => $exp['job_title'],
                        'company_name' => $exp['company_name'],
                        'from' => $exp['from'],
                        'to' => $exp['to'],
                    ];
                });

                foreach ($experiences as $experience) {
                    $user->experiences()->create($experience);
                }
            }
            if ($request->has('license')) {
                $licenses = collect($request->license)->map(function ($license) use ($user) {
                    $fileName = null;
                    if (isset($license['license_image']) && $license['license_image']) {
                        $file = $request->file('license_image')[$license['license_image']];
                        if ($file->isValid()) {
                            $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path('licenses'), $fileName);
                        }
                    }

                    return [
                        'user_id' => $user->id,
                        'license_name' => $license['license_name'],
                        'license_id' => $license['license_id'],
                        'from' => $license['from'],
                        'to' => $license['to'],
                        'license_image' => $fileName,
                    ];
                });

                foreach ($licenses as $license) {
                    $user->licenses()->create($license);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Professional profile updated successfully.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'error' => $e->getMessage(),], 500);
        }
    }

    public function ProfileImagesUpdate(Request $request, $user_id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'image' => 'nullable|file',
                'credentials' => 'nullable|file',
            ]);

            $user = User::findOrFail($user_id);  // Find user by ID

            // Ensure the user exists
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found.'], 404);
            }

            $profile = $user->professionalProfile()->first(); // Assuming you already have a profile

            // Check if the profile exists, if not, create it
            if (!$profile) {
                return response()->json(['status' => false, 'message' => 'Professional profile not found.'], 404);
            }

            // Upload the professional profile image
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = time() . '_' . $user->id . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('profile_image'), $imageName);
                $user->update(['image' => $imageName]);
            }

            // Upload the credentials image
            if ($request->hasFile('credentials')) {
                $file = $request->file('credentials');
                $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('credentials'), $fileName);
                $profile->credentials = $fileName;
                $profile->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profile images updated successfully.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
