<?php

namespace App\Http\Controllers;

use DB;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', get_defined_vars());
    }

    public function getStats(Request $request)
    {
        $roleName = roleName();
        $user = Auth::user();

        try {
            // Bookings stats
            $totalBookings = Booking::count();
            $newBookings = Booking::where('status', 'new')->count();
            $pendingBookings = Booking::where('status', 'pending')->count();
            $confirmedBookings = Booking::where('status', 'confirmed')->count();
            $completedBookings = Booking::where('status', 'completed')->count();
            $cancelledBookings = Booking::where('status', 'cancelled')->count();

            // Vehicles stats
            $totalVehicles = Vehicle::count();
            $activeVehicles = Vehicle::where('is_active', 1)->count();
            $inactiveVehicles = Vehicle::where('is_active', 0)->count();

            return response()->json([
                'status' => true,
                'stats' => [
                    // Bookings
                    'total-bookings' => $totalBookings,
                    'new-bookings' => $newBookings,
                    'pending-bookings' => $pendingBookings,
                    'confirmed-bookings' => $confirmedBookings,
                    'completed-bookings' => $completedBookings,
                    'cancelled-bookings' => $cancelledBookings,

                    // Vehicles
                    'total-vehicles' => $totalVehicles,
                    'active-vehicles' => $activeVehicles,
                    'inactive-vehicles' => $inactiveVehicles,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function getMonthlyAnalytics(Request $request)
{
    $month = $request->input('month', date('n'));
    $year = $request->input('year', date('Y'));

    // Get days in selected month
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    $dates = [];
    $confirmedData = [];
    $completedData = [];
    $pendingData = [];
    $cancelledData = [];

    // Initialize arrays with 0 for each day
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $dates[] = $day;

        // Count bookings for each status on this date
        // This counts bookings that were created, updated, or exist on this date
        $confirmedData[] = Booking::whereDate('created_at', '<=', $date)
            ->where(function($query) use ($date) {
                $query->where('status', 'confirmed')
                      ->whereDate('created_at', '<=', $date)
                      ->orWhere(function($q) use ($date) {
                          $q->where('status', '!=', 'confirmed')
                            ->whereDate('updated_at', '<=', $date);
                      });
            })
            ->count();

        $completedData[] = Booking::where('status', 'completed')
            ->whereDate('created_at', '<=', $date)
            ->where(function($query) use ($date) {
                $query->whereDate('updated_at', '>=', $date)
                      ->orWhere(function($q) use ($date) {
                          $q->whereDate('created_at', '=', $date)
                            ->where('status', 'completed');
                      });
            })
            ->count();

        $pendingData[] = Booking::where('status', 'pending')
            ->whereDate('created_at', '<=', $date)
            ->count();

        $cancelledData[] = Booking::where('status', 'cancelled')
            ->whereDate('created_at', '<=', $date)
            ->count();
    }

    // For monthly summary, count bookings that exist during the month
    // (created in the month OR had status changes in the month)
    $startDate = "$year-$month-01";
    $endDate = "$year-$month-$daysInMonth";

    $monthlyConfirmed = Booking::where('status', 'confirmed')
        ->where(function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                  ->orWhereBetween('updated_at', [$startDate, $endDate]);
        })
        ->count();

    $monthlyCompleted = Booking::where('status', 'completed')
        ->where(function($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                  ->orWhereBetween('updated_at', [$startDate, $endDate]);
        })
        ->count();

    $monthlyPending = Booking::where('status', 'pending')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    $monthlyCancelled = Booking::where('status', 'cancelled')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Total bookings for the month (all bookings created in the month)
    $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Calculate monthly totals
    $summary = [
        'total-bookings' => $totalBookings,
        'confirmed' => $monthlyConfirmed,
        'completed' => $monthlyCompleted,
        'pending' => $monthlyPending,
        'cancelled' => $monthlyCancelled,
    ];

    return response()->json([
        'status' => true,
        'data' => [
            'dates' => $dates,
            'confirmed' => $confirmedData,
            'completed' => $completedData,
            'pending' => $pendingData,
            'cancelled' => $cancelledData,
            'summary' => $summary
        ]
    ]);
}
}


