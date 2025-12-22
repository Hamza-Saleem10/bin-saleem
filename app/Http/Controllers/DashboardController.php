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

        $bookings = Booking::query();
        $vehicles = Vehicle::query();
        $reviews = Review::query();

        // Apply role-based filters
        if ($roleName == 'Driver') {
            $bookings->where('driver_id', $user->id);
            $reviews->whereHas('booking', function ($q) use ($user) {
                $q->where('driver_id', $user->id);
            });
        } elseif ($roleName == 'Customer') {
            $bookings->where('customer_id', $user->id);
            $reviews->where('user_id', $user->id);
        } elseif ($roleName == 'Fleet Manager') {
            $bookings->whereHas('vehicle', function ($q) use ($user) {
                $q->where('fleet_manager_id', $user->id);
            });
            $vehicles->where('fleet_manager_id', $user->id);
        }

        // Get filtered data
        $bookings = $bookings->get();
        $vehicles = $vehicles->get();
        $reviews = $reviews->get();

        // Calculate stats
        $totalBookings = $bookings->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $completedBookings = $bookings->where('status', 'completed')->count();
        $cancelledBookings = $bookings->where('status', 'cancelled')->count();

        $totalVehicles = $vehicles->count();
        $activeVehicles = $vehicles->where('status', 'active')->count();
        $inactiveVehicles = $vehicles->where('status', 'inactive')->count();
        $underMaintenanceVehicles = $vehicles->where('status', 'maintenance')->count();

        $totalReviews = $reviews->count();
        $positiveReviews = $reviews->where('rating', '>=', 4)->count();
        $negativeReviews = $reviews->where('rating', '<=', 2)->count();
        $averageRating = $reviews->avg('rating');

        $stats = [
            'total-bookings' => $totalBookings,
            'pending-bookings' => $pendingBookings,
            'confirmed-bookings' => $confirmedBookings,
            'completed-bookings' => $completedBookings,
            'cancelled-bookings' => $cancelledBookings,

            'total-vehicles' => $totalVehicles,
            'active-vehicles' => $activeVehicles,
            'inactive-vehicles' => $inactiveVehicles,
            'under-maintenance-vehicles' => $underMaintenanceVehicles,

            'total-reviews' => $totalReviews,
            'positive-reviews' => $positiveReviews,
            'negative-reviews' => $negativeReviews,
            'average-rating' => $averageRating,
        ];

        return response()->json([
            'status' => true,
            'stats' => $stats
        ]);
    }

}
