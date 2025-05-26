<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\ProfessionalEarning;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase as FacadesFirebase;

class DashboardController extends Controller
{

    public function sendDummyNotification()
    {
        // Firebase Cloud Message ka data
        $message = CloudMessage::withTarget('token', 'cuX3XlyxSSWViCTq0im_-e:APA91bH7DOBImSSQZJCPmHVEfQZCm1WTe66qa3Y1fUWIwNis08mJNUSv4m4ydyTOpT7DnnHaZaE5byKdJSK6Rcye_ArHzwOzPasBtzowrNpXC7qMC67nTRs')
            ->withNotification([
                'title' => 'Test Notification',
                'body' => 'Omer kesaq laga',
            ]);
    
        // Notification send karna
        $response = FacadesFirebase::messaging()->send($message);
    
        return response()->json([
            'message' => 'Notification Sent!',
            'result' => $response
        ]);
    }

    public function index(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            // Parse the date from the request, default to current month if no date is selected
            $date = $request->has('date') ? Carbon::parse($request->date) : Carbon::now();

            // Get earnings for the current selected month
            $currentMonthEarnings = Payment::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount');

            // Get earnings for the previous month
            $lastMonthEarnings = Payment::whereMonth('created_at', $date->copy()->subMonth()->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount');

            // Calculate the admin and professional earnings
            $adminEarningsCurrentMonth = $currentMonthEarnings * 0.09;
            $professionalEarningsCurrentMonth = $currentMonthEarnings - $adminEarningsCurrentMonth;

            $adminEarningsLastMonth = $lastMonthEarnings * 0.09;
            $professionalEarningsLastMonth = $lastMonthEarnings - $adminEarningsLastMonth;

            // Calculate the percentage change from last month to current month
            $percentageChangeCurrentVsLastMonth = 0;
            if ($lastMonthEarnings > 0) {
                $percentageChangeCurrentVsLastMonth = (($currentMonthEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100;
            }

            // Other data (users, bookings, etc.)
            $data['totalUsers'] = User::where('role', 'caregiver')->count();
            $data['totalProfessionals'] = User::where('role', 'professional')->count();
            $data['totalBookings'] = Booking::where('status', 'completed')->count();
            $data['totalDispute'] = Booking::with('user', 'professional')->where('status', 'dispute')->orderBy('id', 'desc')->get();
            $data['totalPendingOrOther'] = Booking::where('status', 'request')
                ->orWhere('status', 'pending')
                ->orWhere('status', 'accepted')
                ->count();

            // Earnings data to be passed to the view
            $data['currentMonthEarnings'] = $currentMonthEarnings;
            $data['lastMonthEarnings'] = $lastMonthEarnings;
            $data['adminEarningsCurrentMonth'] = $adminEarningsCurrentMonth;
            $data['professionalEarningsCurrentMonth'] = $professionalEarningsCurrentMonth;
            $data['adminEarningsLastMonth'] = $adminEarningsLastMonth;
            $data['professionalEarningsLastMonth'] = $professionalEarningsLastMonth;
            $data['percentageChangeCurrentVsLastMonth'] = number_format($percentageChangeCurrentVsLastMonth, 2);

            // Pass the selected date to the view (used for initializing the calendar)
            $data['selectedDate'] = $date->toDateString(); // In 'Y-m-d' format

            $data['totalAppointmentAccepted'] = Booking::where('status', 'accepted')->orderBy('id', 'desc')->get();
            $data['totalAppointmentRequest'] = Booking::where('status', 'request')->orderBy('id', 'desc')->get();
            $data['totalAppointmentCompleted'] = Booking::where('status', 'completed')->orderBy('id', 'desc')->get();
            $data['totalAppointmentDispute'] = Booking::where('status', 'dispute')->orderBy('id', 'desc')->get();
            $data['totalAppointmentCancelled'] = Booking::where('status', 'canceled')->orderBy('id', 'desc')->get();
            //  return 'Pending wale' . $data['totalAppointmentAccepted'];

            // Return the view with the data
            return view("admin.dashboard", $data);
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function getEarnings(Request $request)
    {
        $startDate = Carbon::parse($request->startDate)->startOfDay();  // Din ke start ko select karein
        $endDate = Carbon::parse($request->endDate)->endOfDay();        // Din ke end ko select karein

        // Current range ke earnings
        $currentMonthEarnings = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        // Previous range ke earnings (iss example mein ek month pehle ka range le rahein hain)
        $lastMonthStart = $startDate->copy()->subMonth();
        $lastMonthEnd = $endDate->copy()->subMonth();

        $lastMonthEarnings = Payment::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');

        $adminEarningsCurrentMonth = $currentMonthEarnings * 0.09;
        $professionalEarningsCurrentMonth = $currentMonthEarnings - $adminEarningsCurrentMonth;

        $adminEarningsLastMonth = $lastMonthEarnings * 0.09;
        $professionalEarningsLastMonth = $lastMonthEarnings - $adminEarningsLastMonth;

        $percentageChangeCurrentVsLastMonth = 0;
        if ($lastMonthEarnings > 0) {
            $percentageChangeCurrentVsLastMonth = (($currentMonthEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100;
        }

        return response()->json([
            'currentMonthEarnings' => number_format($currentMonthEarnings, 2),
            'adminEarningsCurrentMonth' => number_format($adminEarningsCurrentMonth, 2),
            'professionalEarningsCurrentMonth' => number_format($professionalEarningsCurrentMonth, 2),
            'lastMonthEarnings' => number_format($lastMonthEarnings, 2),
            'adminEarningsLastMonth' => number_format($adminEarningsLastMonth, 2),
            'professionalEarningsLastMonth' => number_format($professionalEarningsLastMonth, 2),
            'percentageChangeCurrentVsLastMonth' => number_format($percentageChangeCurrentVsLastMonth, 2)
        ]);
    }






    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Successfully logout');
    }
}
