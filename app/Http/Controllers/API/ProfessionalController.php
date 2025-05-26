<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\ProfessionalEarning;
use App\Models\User;
use App\Models\ZoomMeeting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{

    public function postAvailability(Request $request)
    {
        try {
            // Validate the time_slots input to ensure it's provided
            $validated = $request->validate([
                'time_slots' => 'required',  // Ensure it's present
            ]);

            // Check if time_slots is an array already, otherwise treat it as a string
            $timeSlots = is_array($validated['time_slots'])
                ? $validated['time_slots']   // If it's already an array, use it directly
                : explode(',', $validated['time_slots']);  // If it's a string, split by commas

            // Loop through each time slot and process it
            foreach ($timeSlots as $slot) {
                $slot = trim($slot); // Trim extra spaces around the slot

                // Try to handle the data, whether it's a string, date, or integer
                try {
                    // If it's a date, we will try to parse it as a date, otherwise just store as-is
                    $startDateTime = Carbon::parse($slot); // If the value is a valid date string, it will parse successfully.
                } catch (\Exception $e) {
                    // If parsing fails (e.g., for integers or other types), keep the original slot value
                    $startDateTime = $slot; // We just use the raw string or number
                }

                // Now, let's handle the slot (whether it's a date or some other type)
                if ($startDateTime instanceof Carbon) {
                    // If it's a valid Carbon date, format it
                    $formattedSlot = $startDateTime->format('Y-m-d H:i:s.u');
                } else {
                    // If it's not a date, just use it as-is (could be a string or integer)
                    $formattedSlot = $startDateTime;
                }

                // Check if the slot already exists for this user
                $existingSlot = Availability::where('user_id', auth()->id())
                    ->where('time_slot', $formattedSlot)
                    ->first();

                if ($existingSlot) {
                    // If the slot exists, update it
                    $existingSlot->update([
                        'status' => 'available',
                        'updated_at' => now(),
                    ]);
                } else {
                    // If the slot doesn't exist, create a new record
                    Availability::create([
                        'user_id' => auth()->id(),
                        'time_slot' => $formattedSlot,
                        'status' => 'available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return response()->json(['status' => true, 'message' => 'Slots processed successfully!']);
        } catch (\Exception $e) {
            // Return an error response if something goes wrong
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }




    // all appointments get processed
    public function appointmentRequestAll(Request $request)
    {
        try {
            $professionalId = auth()->id();
            $professional = User::where('id', $professionalId)->where('role', 'professional')->first();

            if (!$professional) {
                return response()->json([
                    'error' => 'Professional not found.',
                ], 404);
            }

            $date = $request->query('date');
            $bookingsQuery = Booking::where('professional_id', $professionalId)->where('status', 'request');

            if ($date) {
                $bookingsQuery->where('date', $date);
            }

            $bookings = $bookingsQuery->with('user:id,first_name,last_name')->get();

            // Transform bookings to include full_name and booking_id
            $bookingsTransformed = $bookings->map(function ($booking) {
                return [
                    'booking_id' => 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT), // Generate booking ID
                    'full_name' => $booking->user->first_name . ' ' . $booking->user->last_name,
                    'date' => $booking->date,
                    'time_slot' => $booking->time_slot,
                    'status' => $booking->status,
                    'note' => $booking->note,
                ];
            });

            return response()->json([
                'status' => true,
                'RequestAppointment' => $bookingsTransformed,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
    public function acceptBooking(Request $request)
    {
        try {
            $validated = $request->validate([
                'booking_id' => 'required|exists:bookings,id',
            ]);
            $professionalId = auth()->id();
            $booking = Booking::where('id', $validated['booking_id'])
                ->where('professional_id', $professionalId)
                ->first();
            if (!$booking) {
                return response()->json([
                    'error' => 'Booking not found or you are not authorized to accept this booking.',
                ], 404);
            }
            $booking->update([
                'status' => 'accepted',
            ]);

            $authUser = auth()->user();

            Notification::create([
                'user_id' => $booking->user->id,
                'message' => $authUser->first_name . ' has Accept your Appoinment ',
                'notifyBy' => 'Appoinment Accepted',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Booking accepted successfully!',
                'fcm_token' => $booking->user->fcm_token,
                'booking' => [
                    'booking_id' => 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT), // Generate formatted booking ID
                    'full_name' => $booking->user->first_name . ' ' . $booking->user->last_name,
                    'date' => $booking->date,
                    'time_slot' => $booking->time_slot,
                    'status' => $booking->status,
                ],
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function cancelBooking(Request $request)
    {
        try {
            $validated = $request->validate([
                'booking_id' => 'required|exists:bookings,id', // Ensure booking exists
                'reason' => 'required|string|max:255', // Reason for cancellation is required
                'details' => 'nullable|string', // Optional details
            ]);

            // Authenticated user's ID (professional or user)
            $userId = auth()->id();
            $userRole = auth()->user()->role; // Assuming 'role' defines 'professional' or 'user'

            // Fetch the booking
            $booking = Booking::where('id', $validated['booking_id'])->first();

            if (!$booking) {
                return response()->json([
                    'error' => 'Booking not found.',
                ], 404);
            }

            $cancelBy = null;

            // Check which role is cancelling the booking
            if ($userRole == 'professional') {
                $cancelBy = 'professional';
            } elseif ($userRole == 'caregiver') {
                $cancelBy = 'caregiver';
            }

            if ($cancelBy) {
                // Update booking status to 'canceled'
                $booking->update([
                    'status' => 'canceled',
                    'cancel_reason' => $validated['reason'],
                    'cancel_details' => $validated['details'] ?? null,
                    'cancel_by' => $cancelBy, // Who canceled the booking
                ]);

                // If professional canceled, make availability available again
                if ($userRole == 'professional') {
                    $availability = Availability::where('id', $booking->availability_id)->first();

                    if ($availability) {
                        $availability->update(['status' => 'available']);
                    }
                }

                if ($userRole == 'professional') {
                    $fcmToken = $booking->user->fcm_token;
                    $authUser = auth()->user();
                    Notification::create([
                        'user_id' => $booking->user->id,
                        'message' => $authUser->first_name . ' has Cancelled your Appoinment ',
                        'notifyBy' => 'Appoinment Cancelled',
                    ]);
                } else {
                    $fcmToken = $booking->professional->fcm_token;
                    $authUser = auth()->user();
                    Notification::create([
                        'user_id' => $booking->professional->id,
                        'message' => $authUser->first_name . ' has Accept your Appoinment ',
                        'notifyBy' => 'Appoinment Accepted',
                    ]);
                }
                return response()->json([
                    'message' => 'Booking canceled successfully!',
                    'booking' => [
                        'booking_id' => 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT),
                        'full_name' => $booking->user->first_name . ' ' . $booking->user->last_name,
                        'date' => $booking->date,
                        'time_slot' => $booking->time_slot,
                        'status' => $booking->status,
                        'reason' => $booking->cancel_reason,
                        'details' => $booking->cancel_details,
                        'cancel_by' => $cancelBy, // Return who canceled the booking
                        'fcm_token' => $fcmToken,
                    ],
                    // Return the relevant FCM token
                ]);
            } else {
                return response()->json([
                    'error' => 'Invalid role for booking cancellation.',
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    // isme sarii status ke appointment arahe hen
    public function manageAppointment(Request $request)
    {
        try {
            $userId = auth()->id();
            $userRole = auth()->user()->role;

            if ($userRole == 'professional') {
                $appointments = Booking::where('professional_id', $userId)
                    ->with('user:id,first_name,last_name,image')
                    ->get();
            } elseif ($userRole == 'caregiver') {
                $appointments = Booking::where('user_id', $userId)
                    ->with('professional:id,first_name,last_name,image')
                    ->get();
            }

            // Transform the bookings
            $appointmentsTransformed = $appointments->map(function ($booking) use ($userRole) {
                $fullName = '';
                $image = '';

                if ($userRole == 'caregiver') {
                    if ($booking->professional) {
                        $fullName = $booking->professional->first_name . ' ' . $booking->professional->last_name;
                        $image = asset('profile_image/' . $booking->professional->image);
                    }
                } else {
                    if ($booking->user) {
                        $fullName = $booking->user->first_name . ' ' . $booking->user->last_name;
                        $image = asset('profile_image/' . $booking->user->image);
                    }
                }

                return [
                    'id' => $booking->id,
                    'booking_id' => 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT), // Format booking ID
                    'full_name' => $fullName,
                    'image' => $image,
                    'date' => $booking->date,
                    'time_slot' => $booking->time_slot,
                    'status' => $booking->status,
                    'note' => $booking->note,
                    'cancelBy' => $booking->cancel_by,
                ];
            });



            return response()->json([
                'status' => true,
                'appointments' => $appointmentsTransformed,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    // accept ki koi sepcific
    public function specifiedRequest($id)
    {
        try {
            $userId = auth()->id();  // Get authenticated user's ID
    
            // Get Zoom meeting link based on the booking ID
            $zoomMeeting = ZoomMeeting::where('booking_id', $id)->first();
    
            if (!$zoomMeeting) {
                return response()->json([
                    'error' => 'Zoom meeting not found for this booking.',
                ], 404);
            }
    
            $userRole = auth()->user()->role;  // Get current user's role (user or professional)
    
            // Get the booking based on the user's role
            if ($userRole == 'professional') {
                $booking = Booking::where('id', $id)
                    ->where('professional_id', $userId)  // Match booking with professional's ID
                    ->with('user:id,first_name,last_name,image') // Get user details
                    ->first();
            } elseif ($userRole == 'caregiver') {
                $booking = Booking::where('id', $id)
                    ->where('user_id', $userId)  // Match booking with user's ID
                    ->with(['professional:id,first_name,last_name,image', 'professional.professionalProfile']) // Add professionalProfile relation here
                    ->first();
            } else {
                return response()->json([
                    'error' => 'Invalid user role.',
                ], 400);
            }
    
            // If booking is not found
            if (!$booking) {
                return response()->json([
                    'error' => 'Booking not found.',
                ], 404);
            }
    
            // Get Hour Rate for Professional and Caregiver
            $hourRate = null;
    
            if ($userRole == 'professional') {
                // If the logged-in user is a professional, fetch their hour_rate
                $hourRate = $booking->professional->professionalProfile->hour_rate;
                $whatis = $booking->professional->professionalProfile->professional_field;
            } elseif ($userRole == 'caregiver') {
                $whatis = $booking->professional->professionalProfile->professional_field;
                $hourRate = $booking->professional->professionalProfile->hour_rate;
            }
    
            // Transform booking data for the response
            $bookingTransformed = [
                'booking_id' => 'NJE' . str_pad($booking->id, 9, '0', STR_PAD_LEFT),
                'user_id' => $booking->user_id,
                'userName' => $userRole == 'caregiver' 
                    ? $booking->user->first_name . ' ' . $booking->user->last_name 
                    : $booking->user->first_name . ' ' . $booking->user->last_name,
                'userImage' => asset('profile_image/' . $booking->user->image),
                'professional_id' => $booking->professional_id,
                'professionalName' => $userRole == 'professional' 
                    ? $booking->professional->first_name . ' ' . $booking->professional->last_name 
                    : $booking->professional->first_name . ' ' . $booking->professional->last_name,
                'professionalImage' => $userRole == 'professional' 
                    ? asset('profile_image/' . $booking->professional->image) 
                    : asset('profile_image/' . $booking->professional->image),
                'date' => $booking->created_at->format('Y-m-d'),
                'duration' => "1 Hour",
                'role' => Auth::user()->role,
                'time_slot' => $booking->time_slot,
                'status' => $booking->status,
                'note' => $booking->note,
                'zoom_link' => $zoomMeeting->join_url,
                'hour_rate' => $hourRate, // Add the hour_rate for professional or caregiver
                'whatis' => $whatis ?? 'Customer', // Add the hour_rate for professional or caregiver
                'cancel_reason' => $booking->cancel_reason ?? 'N/A',
                'cancel_details' => $booking->cancel_details ?? 'N/A',
                'cancel_by' => $booking->cancel_by ?? 'N/A',
                'reason_dispute' => $booking->reason_dispute ?? 'N/A',
                'dispute_details' => $booking->dispute_details ?? 'N/A',
            ];
    
            return response()->json([
                'status' => true,
                'booking' => $bookingTransformed,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }



    public function countRequest(Request $request)
    {
        $professionalId = auth()->id();

        $professional = User::where('id', $professionalId)
            ->where('role', 'professional')
            ->first();

        if (!$professional) {
            return response()->json([
                'error' => 'Professional not found.',
            ], 404);
        }

        // Force casting to integer
        $earning = (int) ProfessionalEarning::where('professional_id', $professionalId)->sum('earning_amount');

        $bookingRequest = Booking::where('professional_id', $professionalId)
            ->where('status', 'request')
            ->count();

        // `completed` status wale bookings ka count
        $bookingCompleted = Booking::where('professional_id', $professionalId)
            ->where('status', 'completed')
            ->count();

        // Dono counts ko return karte hain
        return response()->json([
            'success' => true,
            'earning' => $earning,
            'request_count' => $bookingRequest,
            'completed_count' => $bookingCompleted,
        ]);
    }
}
