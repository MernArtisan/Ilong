<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\DisputeNotification;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\ContentPostComment;
use App\Models\Group;
use App\Models\ProfessionalEarning;
use App\Models\ProfessionalProfile;
use App\Models\User;
use App\Models\UserVideo;
use App\Models\VideoComment;
use App\Models\VideoLike;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\ZoomMeetingCreate;
use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Post;
use App\Models\ZoomMeeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DiscoverController extends Controller
{

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $user = auth()->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();

        $NotificationCount = $user = Notification::where('user_id', $user->id)->where('seen', 0)->where('notifyBy', '!=', 'admin Contact')->count();

        return response()->json([
            'status' => true,
            'notification_count' => $NotificationCount,
            'message' => 'FCM token updated successfully!',
        ], 200);
    }
    public function getProfessional()
    {
        try {
            $professional = User::select(
                'id',
                'first_name',
                'last_name',
                'role',
                'image',
                DB::raw("CONCAT(first_name, ' ', last_name) as full_name")
            )
                ->where('role', 'professional')
                ->where('login_status', 'approve')
                ->with('professionalProfile') // Ensure we load the professionalProfile relation
                ->get()
                ->map(function ($user) {
                    $user->image = asset('profile_image/' . $user->image);

                    $user->hour_rate = $user->professionalProfile->hour_rate ?? null;

                    return $user;
                });

            return response()->json([
                'status' => true,
                'professional' => $professional,
                'message' => 'Professional Fetched Successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ]);
        }
    }


    public function getSpecificProfessional($id)
    {
        try {
            $profession = User::with('professionalProfile', 'experiences', 'licenses')->findOrFail($id);
            $fullName = trim($profession->first_name . ' ' . $profession->last_name);

            // Check if skills and languages are arrays or JSON strings and decode them if necessary
            $skills = is_string($profession->professionalProfile->skills)
                ? json_decode($profession->professionalProfile->skills, true)
                : $profession->professionalProfile->skills ?? ['N/A'];

            $languages = is_string($profession->professionalProfile->languages)
                ? json_decode($profession->professionalProfile->languages, true)
                : $profession->professionalProfile->languages ?? ['N/A'];

            // Calculate total experience in months
            $totalExperienceMonths = 0;

            foreach ($profession->experiences as $experience) {
                $fromDate = \Carbon\Carbon::parse($experience->from);
                // If 'to' is null, use the current date for ongoing experience
                $toDate = $experience->to ? \Carbon\Carbon::parse($experience->to) : now();

                // Calculate the difference in months for each experience
                $diffInMonths = $fromDate->diffInMonths($toDate);
                $totalExperienceMonths += $diffInMonths;
            }

            // Convert total months to years and months
            $totalExperienceYears = intdiv($totalExperienceMonths, 12);
            $remainingMonths = $totalExperienceMonths % 12;

            // Prepare the experience string
            $experienceString = $totalExperienceYears . ' years';
            if ($remainingMonths > 0) {
                $experienceString .= ' and ' . $remainingMonths . ' months';
            }

            return response()->json([
                "status" => true,
                "professional" => [
                    'id' => $profession->id,
                    'name' => $fullName,
                    'email' => $profession->email,
                    'image' => asset(($profession->image ? 'profile_image/' . $profession->image : 'default.png')),
                    'cover_image' => asset(($profession->cover_image ? 'profile_image/' . $profession->cover_image : 'default.png')),
                    'country' => $profession->country,
                    'professional_field' => $profession->professionalProfile->professional_field ?? 'N/A',
                    'credentials' => asset('credentials/' . $profession->professionalProfile->credentials),
                    'education_degrees' => $profession->professionalProfile->education_degrees ?? 'N/A',
                    'certifications' => $profession->professionalProfile->certifications ?? 'N/A',
                    'skills' => $skills ?? null,
                    'languages' => $languages,
                    'website' => $profession->professionalProfile->website ?? 'N/A',
                    'about' => $profession->professionalProfile->about ?? 'N/A',
                    'hour_rate' => $profession->professionalProfile->hour_rate ?? '100',
                    'experience' => $experienceString, // Include experience string in the response
                ],
                "message" => "Professional fetched successfully",
            ]);
        } catch (Exception $exception) {
            return response()->json([
                "status" => false,
                "error" => $exception->getMessage(),
            ], 404);
        }
    }

    public function getAvailableSlots($userId, Request $request)
    {
        try {
            $date = $request->input('date');
            $parsedDate = Carbon::parse($date)->setTimezone('UTC');
            $formattedDate = $parsedDate->format('Y-m-d H:i:s');
            $availableSlots = Availability::where('user_id', $userId)->where('status', 'available')
                ->whereDate('time_slot', '=', $parsedDate->toDateString())
                ->get();

            return response()->json([
                'status' => true,
                'available_slots' => $availableSlots,
                'date' => $formattedDate,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function BookSlot(Request $request)
    {
        try {
            $validated = $request->validate([
                'availability_id' => 'required|exists:availabilities,id',
                'note' => 'nullable|string',
                'amount' => 'required|numeric', // Payment amount is required
                'intent_id' => 'required|string', // Payment intent ID from Flutter
            ]);

            $userId = auth()->id();
            $availabilityId = $validated['availability_id'];
            $availability = Availability::where('id', $availabilityId)
                ->where('status', 'available')
                ->first();

            if (!$availability) {
                return response()->json(['error' => 'The selected slot is not available'], 400);
            }

            $booking = Booking::create([
                'user_id' => $userId,
                'professional_id' => $availability->user_id,
                'availability_id' => $availability->id,
                'date' => $availability->date,
                'time_slot' => $availability->time_slot,
                'note' => $validated['note'] ?? null,
                'status' => 'request',
            ]);
            $payment = Payment::create([
                'user_id' => $userId,
                'professional_id' => $availability->user_id,
                'booking_id' => $booking->id,
                'amount' => $validated['amount'], // Payment amount
                'intent_id' => $validated['intent_id'], // Flutter payment intent ID
                'status' => 'completed',
            ]);

            $zoomResponse = $this->createZoomMeeting($availability, $booking);

            if ($zoomResponse['status'] === false) {
                return response()->json(['error' => 'Failed to create Zoom meeting'], 500);
            }
            $availability->update(['status' => 'booked']);

            $user = User::find($userId);
            $professional = User::find($availability->user_id);

            Mail::to($user->email)->send(new ZoomMeetingCreate($zoomResponse['data'], $user, $booking, false));
            Mail::to($professional->email)->send(new ZoomMeetingCreate($zoomResponse['data'], $professional, $booking, true));
            $authUser = auth()->user();

            Notification::create([
                'user_id' => $professional->id,
                'message' => $authUser->first_name . 'has Book your Slot ',
                'notifyBy' => 'Book Slot Added',
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Booking created successfully and Zoom link sent to both parties!',
                'booking' => $booking,
                'fcm_token' => $professional->fcm_token,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                "error" => $exception->getMessage()
            ]);
        }
    }
    protected function createZoomMeeting($availability, $booking)
    {
        try {

            $topicName = 'Topic -  ' . $booking->note;

            $zoomResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->generateToken(),
                'Content-Type' => 'application/json',
            ])->post('https://api.zoom.us/v2/users/me/meetings', [
                'topic' => $topicName,
                'type' => 2,
                'start_time' => Carbon::parse($availability->date . ' ' . $availability->time_slot)->toIso8601String(),
                'duration' => 60,
                'timezone' => Carbon::now()->tzName,
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'waiting_room' => false,
                    'join_before_host' => true,
                ],
            ]);

            if ($zoomResponse->successful()) {
                $data = $zoomResponse->json();

                $zoom_meeting = ZoomMeeting::create([
                    'meeting_id' => $data['id'],
                    'host_id' => $data['host_id'],
                    'booking_id' => $booking->id,
                    'topic' => $data['topic'],
                    'start_time' => $data['start_time'],
                    'duration' => $data['duration'],
                    'password' => $data['password'],
                    'start_url' => $data['start_url'],
                    'join_url' => $data['join_url'],
                    'status' => $data['status'],
                    'professional_id' => $availability->user_id,
                    'user_id' => Auth::user()->id,
                    'availability_id' => $availability->id,
                ]);
                return [
                    'status' => true,
                    'data' => $zoomResponse->json(),
                ];
            } else {
                Log::error('Failed to create Zoom meeting', ['response' => $zoomResponse->json()]);
                return ['status' => false, 'message' => 'Failed to create Zoom meeting'];
            }
        } catch (Exception $e) {
            Log::error('An error occurred while creating Zoom meeting', ['exception' => $e]);
            return ['status' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
        }
    }

    protected function generateToken(): string
    {
        try {
            $base64String = base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'));
            $accountId = env('ZOOM_ACCOUNT_ID');

            $responseToken = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => "Basic {$base64String}",
            ])->post("https://zoom.us/oauth/token?grant_type=account_credentials&account_id={$accountId}");

            if ($responseToken->successful()) {
                return $responseToken->json()['access_token'];
            } else {
                Log::error('Failed to generate Zoom token', ['response' => $responseToken->json()]);
                throw new Exception('Failed to generate Zoom token.');
            }
        } catch (Exception $e) {
            Log::error('An error occurred while generating Zoom token', ['exception' => $e]);
            throw new Exception('An error occurred while generating Zoom token: ' . $e->getMessage());
        }
    }
    public function uploadVideos(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mkv',
            'description' => 'required|string|max:1000',
        ]);


        $user = auth()->user();

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('uservideos'), $videoName);

            $userVideo = UserVideo::create([
                'user_id' => $user->id,
                'video' => $videoName,
                'description' => $request->description,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Video uploaded successfully.',
                'video' => $userVideo,
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'No video file found.',
        ], 400);
    }

    public function getVideos(Request $request)
    {
        try {
            // Get authenticated user
            $user = auth()->user();

            // Fetch videos in random order
            $videos = UserVideo::orderBy('id', 'desc')->get();

            // Map through videos to add extra fields like 'is_liked' and 'likes'
            $videos = $videos->map(function ($video) use ($user) {
                // Check if the authenticated user has liked this video
                $isLiked = $user ? VideoLike::where('user_id', $user->id)
                    ->where('video_id', $video->id)
                    ->exists() : false;

                // Get all likes for this video
                $Comments = VideoComment::where('video_id', $video->id)->with('user')->get();

                // Map the likes to get user info
                $CommentWithUsers = $Comments->map(function ($Comment) {
                    return [
                        'user_id' => $Comment->user->id,
                        'user_name' => $Comment->user->first_name . ' ' . $Comment->user->last_name,  // Assuming `name` is a field in the `users` table
                        'image' => asset('profile_image/' . $Comment->user->image),
                        'comment' => $Comment->comment,
                    ];
                });

                return [
                    'id' => $video->id,
                    'user_id' => $video->user_id,
                    'user_name' => $video->user->first_name . ' ' . $video->user->last_name,
                    'video' => asset('uservideos/' . $video->video),
                    'description' => $video->description,
                    'created_at' => $video->created_at->diffForHumans(),
                    'is_liked' => $isLiked,
                    'likeCount' => $video->likes()->count(),
                    'commentCount' => $video->comments()->count(),
                    'Comments' => $CommentWithUsers,
                ];
            });

            return response()->json([
                'status' => true,
                'videos' => $videos,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function likeVideo($videoId)
    {
        $user = auth()->user();
        $video = UserVideo::find($videoId);

        if (!$video) {
            return response()->json([
                'error' => 'Video not found.',
            ], 404);
        }

        $owner = $video->user;

        if (!$owner) {
            return response()->json([
                'status' => false,
                'message' => 'Video owner not found.'
            ]);
        }

        $fcmToken = $owner->fcm_token;
        $UserId = $owner->id;

        $existingLike = VideoLike::where('user_id', $user->id)
            ->where('video_id', $videoId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json([
                'status' => false,
                'message' => 'Video unliked successfully.',
            ], 400);
        }

        $authUser = auth()->user();

        Notification::create([
            'user_id'     => $UserId,
            'message'     => $authUser->first_name . ' has liked your video.',
            'notifyBy'    => 'Like Video',
            'action_type' => 'likedVideo',
            'action_id'   => $videoId,
        ]);

        VideoLike::create([
            'user_id'  => $user->id,
            'video_id' => $videoId,
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Video liked successfully.',
            'fcm_token' => $fcmToken,
        ], 200);
    }


    public function commentOnVideo(Request $request, $videoId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $video = UserVideo::find($videoId);

        if (!$video) {
            return response()->json([
                'status' => false,
                'error' => 'Video not found.',
            ]);
        }

        $owner = $video->user;

        if (!$owner) {
            return response()->json([
                'status' => false,
                'message' => 'Video owner not found.'
            ]);
        }

        $fcmToken = $owner->fcm_token;
        $UserId = $owner->id;

        VideoComment::create([
            'user_id' => $user->id,
            'video_id' => $videoId,
            'comment' => $request->input('comment'),
        ]);

        $authUser = auth()->user();

        Notification::create([
            'user_id'     => $UserId,
            'message'     => $authUser->first_name . ' has commented on your video.',
            'notifyBy'    => 'Commented Video',
            'action_type' => 'commentVideo',
            'action_id'   => $videoId,
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Comment added successfully.',
            'fcm_token' => $fcmToken,
        ]);
    }


    public function MyVideos()
    {
        try {
            $user = auth()->user();

            // Get only videos of the authenticated user
            $videos = UserVideo::with('user') // eager load user
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->get();

            $videos = $videos->map(function ($video) use ($user) {
                $isLiked = VideoLike::where('user_id', $user->id)
                    ->where('video_id', $video->id)
                    ->exists();

                $comments = VideoComment::where('video_id', $video->id)
                    ->with('user')
                    ->get();

                $CommentWithUsers = $comments->map(function ($comment) {
                    return [
                        'user_id' => $comment->user->id,
                        'user_name' => $comment->user->first_name . ' ' . $comment->user->last_name,
                        'image' => asset('profile_image/' . $comment->user->image),
                        'comment' => $comment->comment,
                    ];
                });

                return [
                    'id' => $video->id,
                    'user_id' => $video->user_id,
                    'user_name' => $video->user->first_name . ' ' . $video->user->last_name,
                    'video' => asset('uservideos/' . $video->video),
                    'description' => $video->description,
                    'created_at' => $video->created_at->diffForHumans(),
                    'is_liked' => $isLiked,
                    'likeCount' => $video->likes()->count(),
                    'commentCount' => $video->comments()->count(),
                    'Comments' => $CommentWithUsers,
                ];
            });

            return response()->json([
                'status' => true,
                'videos' => $videos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function deleteMyVideo($id)
    {
        try {
            $user = auth()->user();

            // Find the video and ensure it's owned by the logged-in user
            $video = \App\Models\UserVideo::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$video) {
                return response()->json([
                    'status' => false,
                    'message' => 'Video not found or access denied.'
                ], 404);
            }

            // Delete video file from public/uservideos
            $videoPath = public_path('uservideos/' . $video->video);
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }

            // Delete the video record
            $video->delete();

            return response()->json([
                'status' => true,
                'message' => 'Video deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function editMyVideo(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        try {
            $user = auth()->user();

            // Find user's own video
            $video = \App\Models\UserVideo::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$video) {
                return response()->json([
                    'status' => false,
                    'message' => 'Video not found or access denied.'
                ], 404);
            }

            // Update only description
            $video->description = $request->description;
            $video->save();

            return response()->json([
                'status' => true,
                'message' => 'Video description updated successfully.',
                'video' => [
                    'id' => $video->id,
                    'description' => $video->description,
                    'updated_at' => $video->updated_at->diffForHumans(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function completeBooking(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:bookings,id',
            ]);

            $userId = auth()->id();
            $userRole = auth()->user()->role;

            $booking = Booking::where('id', $validated['id'])->first();

            if (!$booking) {
                return response()->json([
                    'error' => 'Booking not found.',
                ], 404);
            }

            if ($userRole == 'caregiver') {
                if ($booking->user_id != $userId) {
                    return response()->json([
                        'error' => 'You are not authorized to complete this booking.',
                    ], 403);
                }

                $booking->update([
                    'status' => 'completed',
                ]);

                $professionalProfile = ProfessionalProfile::where('user_id', $booking->professional_id)->first();

                if (!$professionalProfile) {
                    return response()->json([
                        'error' => 'Professional profile not found.',
                    ], 404);
                }

                $hourRate = $professionalProfile->hour_rate;

                ProfessionalEarning::create([
                    'professional_id' => $booking->professional_id,
                    'booking_id' => $booking->id,
                    'earning_amount' => $hourRate,
                    'earning_date' => Carbon::now(),
                    'status' => 'Pending',
                    'user_id' => $booking->user_id,
                ]);

                $authUser = auth()->user();

                Notification::create([
                    'user_id' => $booking->professional->id,
                    'message' => $authUser->first_name . 'has Completed Appointment ',
                    'notifyBy' => 'Appointment Completed',
                ]);
                return response()->json([
                    'message' => 'Booking marked as completed and earnings recorded successfully!',
                    'fcm_token' => $booking->professional->fcm_token,
                    'booking' => [
                        'booking_id' => 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT),
                        'status' => $booking->status,
                        'hour_rate' => $hourRate,
                    ],
                ]);
            } else {
                return response()->json([
                    'error' => 'Only users can complete bookings.',
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function disputeBooking(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:bookings,id',
                'reason_dispute' => 'required|string|max:255',
                'dispute_detail' => 'required|string',
            ]);

            $userId = auth()->id();
            $userRole = auth()->user()->role;
            $booking = Booking::where('id', $validated['id'])->first();

            if (!$booking) {
                return response()->json([
                    'error' => 'Booking not found.',
                ], 404);
            }
            if ($booking->user_id != $userId) {
                return response()->json([
                    'error' => 'You are not authorized to dispute this booking.',
                ], 403);
            }

            // Update the booking with dispute details
            $booking->update([
                'status' => 'dispute',
                'reason_dispute' => $validated['reason_dispute'],
                'dispute_detail' => $validated['dispute_detail'],
            ]);

            // Fetch admins (users with role 'admin')
            $admins = User::where('role', 'admin')->get();

            // Fetch the professional related to the booking
            $professional = User::find($booking->professional_id);

            // Send email to admins
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new DisputeNotification($validated, $booking, $admin));
            }

            // Send email to the professional
            if ($professional) {
                Mail::to($professional->email)->send(new DisputeNotification($validated, $booking, $professional));
            }

            $authUser = auth()->user();

            Notification::create([
                'user_id' => $professional->id,
                'message' => $authUser->first_name . 'has Dispute Appointment ',
                'notifyBy' => 'Appointment Dispute',
            ]);

            return response()->json([
                'message' => 'Booking dispute successfully!',
                'fcm_token' => $professional->fcm_token,
                'booking' => [
                    'booking_id' => 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT),
                    'status' => $booking->status,
                    'reason_dispute' => $booking->reason_dispute,
                    'dispute_detail' => $booking->dispute_detail,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $response = [];

        // Get the search term from the query string
        $searchTerm = $request->input('search'); // This will fetch 'search=xyz' from the URL

        // If there's a search term, perform the search
        if ($searchTerm) {
            // Search in users' first_name, last_name, or role
            $userQuery = User::query();
            $userQuery->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('role', 'like', '%' . $searchTerm . '%');
            });

            $users = $userQuery->get();
            foreach ($users as $user) {
                $response[] = [
                    'id' => $user->id,
                    'image' => $user->image ? asset('profile_image/' . $user->image) : asset('default.png'),

                    'name'  => $user->first_name . ' ' . $user->last_name,
                    // 'role'  => $user->role,
                    'type' => $user->role == 'caregiver' ? 'Caregiver' : ($user->role == 'professional' ? 'Professional' : 'Other'),
                ];
            }

            // Search in groups' name
            $groupQuery = Group::query();
            $groupQuery->where('name', 'like', '%' . $searchTerm . '%');

            $groups = $groupQuery->get();
            foreach ($groups as $group) {
                $response[] = [
                    'id' => $group->id,
                    'image' => $group->image ? asset('group_images/' . $group->image) : asset('default.png'),
                    'name'  => $group->name,
                    // 'role'  => $group->creator->role ?? 'N/A',
                    'type' => 'Group',
                ];
            }
        }

        // Return the results
        return response()->json($response);
    }
    public function earning()
    {
        try {
            // Get the authenticated professional user
            $user = Auth::user();

            // Ensure the user is a professional
            if ($user->role !== 'professional') {
                return response()->json([
                    'error' => 'Unauthorized access. Only professionals can view earnings.',
                ], 403);
            }

            // Fetch all earnings for the professional
            $earnings = ProfessionalEarning::where('professional_id', $user->id)->get();

            // Calculate the total earnings
            $totalEarnings = $earnings->sum('earning_amount');

            // Map earnings into the desired format
            $formattedEarnings = $earnings->map(function ($earning) {
                $booking = Booking::find($earning->booking_id);

                return [
                    'booking_id' => $booking ? 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT) : null,
                    'earning_amount' => $earning->earning_amount,
                    'status' => $earning->status,
                    'date_time' => $earning->created_at->format('d M, Y h:i A'),
                ];
            });

            // Return the response with the data
            return response()->json([
                'status' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'image' => asset('profile_image/' . $user->image),
                ],
                'total_earning' => $totalEarnings,  // Return the total earnings
                'earning_history' => $formattedEarnings, // Individual earnings with booking details
            ]);
        } catch (Exception $exception) {
            // Catch errors and return a generic error message
            return response()->json([
                'error' => 'An error occurred: ' . $exception->getMessage(),
            ], 500);
        }
    }



    public function messagePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|string|regex:/^\d+_\d+$/',
            'last_message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();

        $chat_ids = explode('_', $request->chat_id);
        if (count($chat_ids) != 2 || !is_numeric($chat_ids[0]) || !is_numeric($chat_ids[1])) {
            return response()->json(['error' => 'Invalid chat_id format'], 400);
        }

        // Check if a message with the same chat_id already exists
        $existingMessage = Message::where('chat_id', $request->chat_id)->first();

        if ($existingMessage) {
            // If the message exists, update the message
            $existingMessage->last_message = $request->last_message;
            $existingMessage->user_id = $user->id;
            $existingMessage->save();

            return response()->json(['message' => 'Message updated successfully', 'data' => $existingMessage], 200);
        } else {
            // If no message exists, create a new one
            $message = Message::create([
                'chat_id' => $request->chat_id,
                'user_id' => $user->id,
                'last_message' => $request->last_message,
            ]);

            return response()->json(['message' => 'Message stored successfully', 'data' => $message], 201);
        }
    }

    public function getMessages(Request $request)
    {
        $userId = auth()->user()->id;

        $messages = Message::where(function ($query) use ($userId) {
            $query->where('chat_id', 'like', "%$userId%");
        })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($messages->isEmpty()) {
            return response()->json(['message' => 'No messages found for this user'], 404);
        }

        $resultMessages = $messages->map(function ($message) use ($userId) {

            $chatIds = explode('_', $message->chat_id);

            $otherUserId = ($chatIds[0] == $userId) ? $chatIds[1] : $chatIds[0];

            $user = User::find($otherUserId);

            $fullName = $user->first_name . ' ' . $user->last_name;
            return [
                'id' => $message->id,
                'chat_id' => $message->chat_id,
                // 'user_id' => $message->user_id,
                'last_message' => $message->last_message,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
                'user_id' => $user->id,
                'name' => $fullName,
                'fcm_token' => $user->fcm_token,
                'image' => asset('profile_image/' . $user->image),
            ];
        });

        return response()->json(['messages' => $resultMessages], 200);
    }




    public function getSlots(Request $request)
    {
        $user = auth()->user();

        // Check if the user is a professional
        if ($user->role == 'professional') {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to access slots'
            ]);
        } else {
            // Get the slots for the authenticated user
            $slots = Booking::where('user_id', $user->id)->get();

            $timeslots = $slots->map(function ($slots) {
                return [
                    'id' => $slots->id,
                    'time_slot' => $slots->time_slot,
                    'status' => $slots->status,
                ];
            });
            return response()->json([
                'status' => true,
                'data' => $timeslots,
                'message' => 'You are authorized to access slots'
            ]);
        }
    }


    public function seenNotification(Request $request)
    {
        $user = auth()->user();
        $notification = Notification::where('user_id', $user->id)->where('seen', 0)->get();
        $notification->each(function ($notification) {
            $notification->update([
                'seen' => 1,
            ]);
        });
        return response()->json([
            'status' => true,
            'message' => 'Notification has been seen'
        ], 200);
    }


    public function getNotification(Request $request)
    {
        $user = auth()->user();
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->message,
                'notify' => $notification->notifyBy,
                'action_type' => $notification->action_type, // for app redirection
                'action_id' => $notification->action_id,     // for app redirection
                'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
            ];
        });

        return response()->json([
            'status' => true,
            'data' => [
                'notifications' => $notifications,
            ]
        ], 200);
    }


    public function getActionData(Request $request)
    {
        $request->validate([
            'action_type' => 'required|string',
            'action_id' => 'required|integer',
        ]);

        $type = $request->query('action_type');
        $id   = $request->query('action_id');
        $user = auth()->user();

        switch ($type) {
            case 'likePost':
            case 'commentPost':
            case 'sharePostToProfile':
            case 'sharePostToGroup':
            case 'sharedGroupPostToProfile':
                $post = Post::with('images', 'user')->find($id);
                if (!$post) return response()->json(['status' => false, 'message' => 'Post not found.']);

                $comment = null;
                if ($type === 'commentPost') {
                    $comment = ContentPostComment::where('post_id', $id)
                        ->where('user_id', $user->id)
                        ->latest()
                        ->first();
                }

                $group = null;
                if ($type === 'sharePostToGroup' || $type === 'sharedGroupPostToProfile') {
                    $groupPost = GroupPost::with('group')
                        ->latest()
                        ->first();

                    // $group = $groupPost?->group;
                }

                return response()->json([
                    'status' => true,
                    'type' => $type,
                    'data' => [
                        'id' => $post->id,
                        'user_id' => $post->user_id,
                        'image' => $post->user->image
                            ? asset('profile_image/' . $post->user->image)
                            : asset('default.png'),

                        'first_name' => $post->user->first_name,
                        'role' => $post->user->role,
                        'content' => $post->content,
                        'share' => $post->share,
                        'share_person' => $post->share_person,
                        'images' => $post->images->map(fn($img) => asset('contentpost/' . $img->image_path)),
                        'likes' => $post->likes()->count(),
                        'comments' => $post->comments()->count(),
                        'shares' => $post->share_count ?? 0,
                        'is_like' => $post->likes()->where('user_id', $user->id)->exists(),
                        'hide' => $post->hide,
                        'comment_id' => $comment?->id,
                        'comment_text' => $comment?->comment,
                        // 'group' => $group ? [
                            'group_id' => $groupPost->group->id ?? null,
                            'group_name' => $groupPost->group->name ?? null,
                            // 'image' => asset('group_images/' . $group->image),
                            // 'description' => $group->description,
                        // ] : null,
                    ]
                ]);

            case 'groupPostLike':
            case 'groupPostComment':
            case 'sharedGroupPost':
            case 'sharedGroupPostToGroup':
                $groupPost = GroupPost::with(['user', 'group'])->find($id);
                if (!$groupPost) return response()->json(['status' => false, 'message' => 'Group post not found.']);

                $comment = null;
                if ($type === 'groupPostComment') {
                    $comment = Comment::where('post_id', $id)
                        ->where('user_id', $user->id)
                        ->latest()
                        ->first();
                }

                return response()->json([
                    'status' => true,
                    'type' => $type,
                    'data' => [
                        'id' => $groupPost->id,
                        'description' => $groupPost->description,
                        'images' => collect(json_decode($groupPost->image))->map(fn($img) => asset('GroupPosts/' . $img)),
                        'user_id' => $groupPost->user_id,
                        'image' => $groupPost->user->image
                            ? asset('profile_image/' . $groupPost->user->image)
                            : asset('default.png'),
                        'first_name' => $groupPost->user->first_name,
                        'role' => $groupPost->user->role,
                        'likes' => $groupPost->likes()->count(),
                        'comments' => $groupPost->comments()->count(),
                        'shares' => $groupPost->share_count ?? 0,
                        'share' => $groupPost->share,
                        'is_like' => $groupPost->likes()->where('user_id', $user->id)->exists(),
                        'hide' => $groupPost->hide,
                        'share_person' => $groupPost->share_person,
                        'comment_id' => $comment?->id,
                        'comment_text' => $comment?->comment,
                        // 'group' => $group ? [
                            'group_id' => $groupPost->group->id ?? null, // $group->id ?? null,
                            'group_name' => $groupPost->group->name ?? null,
                            // 'image' => asset('group_images/' . $group->image),
                            // 'description' => $group->description,
                        // ] : null,
                    ]
                ]);

            case 'likedVideo':
            case 'commentVideo':
                $video = UserVideo::with(['user', 'comments.user'])->find($id);
                if (!$video) return response()->json(['status' => false, 'message' => 'Video not found.']);

                return response()->json([
                    'status' => true,
                    'type' => $type,
                    'data' => [
                        'id' => $video->id,
                        'user_id' => $video->user_id,
                        'user_name' => $video->user->first_name . ' ' . $video->user->last_name,
                        'video' => asset('uservideos/' . $video->video),
                        'description' => $video->description,
                        'created_at' => $video->created_at->diffForHumans(),
                        'is_liked' => $video->likes()->where('user_id', $user->id)->exists(),
                        'likeCount' => $video->likes()->count(),
                        'commentCount' => $video->comments()->count(),
                        'Comments' => $video->comments->map(function ($c) {
                            return [
                                'user_id' => $c->user_id,
                                'user_name' => $c->user->first_name . ' ' . $c->user->last_name,
                                'image' => asset('profile_image/' . $c->user->image),
                                'comment' => $c->comment,
                            ];
                        })
                    ]
                ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid action type.']);
    }
}
