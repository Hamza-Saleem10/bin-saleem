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

            // Query your bookings for each status on this date
            // Example queries (adjust according to your database structure):
            $confirmedData[] = Booking::whereDate('created_at', $date)
                ->where('status', 'confirmed')->count();
            $completedData[] = Booking::whereDate('created_at', $date)
                ->where('status', 'completed')->count();
            $pendingData[] = Booking::whereDate('created_at', $date)
                ->where('status', 'pending')->count();
            $cancelledData[] = Booking::whereDate('created_at', $date)
                ->where('status', 'cancelled')->count();
        }

        // Calculate monthly totals
        $summary = [
            'total_bookings' => array_sum($confirmedData) + array_sum($completedData) + array_sum($pendingData) + array_sum($cancelledData),
            'confirmed' => array_sum($confirmedData),
            'completed' => array_sum($completedData),
            'pending' => array_sum($pendingData),
            'cancelled' => array_sum($cancelledData),
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


