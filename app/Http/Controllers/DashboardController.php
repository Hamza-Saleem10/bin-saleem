<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Get dashboard statistics
     */
    public function getStats(Request $request)
    {
        try {
            // Get bookings statistics
            $bookingsStats = $this->getBookingsStats();

            // Get vehicles statistics
            $vehiclesStats = $this->getVehiclesStats();

            return response()->json([
                'status' => true,
                'stats' => array_merge($bookingsStats, $vehiclesStats)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get bookings statistics
     */
    private function getBookingsStats()
    {
        $today = Carbon::today();

        $stats = [
            // Total bookings count
            'total-bookings' => Booking::count(),

            // Today's new bookings
            'new-bookings' => Booking::whereDate('created_at', $today)->count(),

            // Status-based counts
            'pending-bookings' => Booking::where('status', 'pending')->count(),
            'confirmed-bookings' => Booking::where('status', 'confirmed')->count(),
            'completed-bookings' => Booking::where('status', 'completed')->count(),
            'cancelled-bookings' => Booking::where('status', 'cancelled')->count(),

            // Additional metrics
            'today-revenue' => Booking::where('status', 'completed')
                ->whereDate('updated_at', $today)
                ->sum('total_amount'),
            'monthly-revenue' => Booking::where('status', 'completed')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->sum('total_amount'),
        ];

        return $stats;
    }

    /**
     * Get vehicles statistics
     */
    private function getVehiclesStats()
    {
        return [
            'total-vehicles' => Vehicle::count(),
            'active-vehicles' => Vehicle::where('is_active', '1')->count(),
            'inactive-vehicles' => Vehicle::where('is_active', '0')->count(),
            // 'under-maintenance-vehicles' => Vehicle::where('maintenance_status', 'maintenance')->count(),

            // Vehicle type breakdown
            'available-vehicles' => Vehicle::where('is_active', 1)
                // ->where('maintenance_status', '!=', 'maintenance')
                ->count(),
        ];
    }

    /**
     * Get monthly analytics data
     */
    /**
     * Get monthly analytics data
     */
    public function getMonthlyAnalytics(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1)
        ]);

        $month = $request->input('month');
        $year = $request->input('year');

        try {
            // Get days in selected month
            $daysInMonth = Carbon::create($year, $month)->daysInMonth;
            $dates = [];

            // Prepare daily data arrays
            $dailyData = [
                'confirmed' => array_fill(1, $daysInMonth, 0),
                'completed' => array_fill(1, $daysInMonth, 0),
                'pending' => array_fill(1, $daysInMonth, 0),
                'cancelled' => array_fill(1, $daysInMonth, 0)
            ];

            // Query bookings for the selected month
            $bookings = Booking::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();

            // Process daily counts
            foreach ($bookings as $booking) {
                $day = (int) $booking->created_at->format('d');
                $status = strtolower($booking->status);

                if (isset($dailyData[$status][$day])) {
                    $dailyData[$status][$day]++;
                }
            }

            // Prepare dates array for chart
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dates[] = $day;
            }

            // Get monthly summary
            $summary = $this->getMonthlySummary($month, $year);

            // Calculate trends (comparison with previous month)
            $previousMonth = Carbon::create($year, $month)->subMonth();
            $previousSummary = $this->getMonthlySummary($previousMonth->month, $previousMonth->year);

            $trends = [
                'confirmed_trend' => $this->calculateTrend($summary['confirmed'], $previousSummary['confirmed']),
                'completed_trend' => $this->calculateTrend($summary['completed'], $previousSummary['completed']),
                'revenue_trend' => $this->calculateTrend($summary['revenue'], $previousSummary['revenue']),
            ];

            return response()->json([
                'status' => true,
                'data' => [
                    'dates' => $dates,
                    'confirmed' => array_values($dailyData['confirmed']),
                    'completed' => array_values($dailyData['completed']),
                    'pending' => array_values($dailyData['pending']),
                    'cancelled' => array_values($dailyData['cancelled']),
                    'summary' => $summary,
                    'trends' => $trends,
                    'month_name' => Carbon::create($year, $month)->format('F Y')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch analytics data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get monthly summary
     */
    private function getMonthlySummary($month, $year)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Get status counts using Eloquent
        $confirmed = Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $completed = Booking::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $pending = Booking::where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $cancelled = Booking::where('status', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Get revenue from completed bookings
        $revenue = Booking::where('status', 'completed')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_amount');

        return [
            'total' => $confirmed + $completed + $pending + $cancelled,
            'confirmed' => $confirmed,
            'completed' => $completed,
            'pending' => $pending,
            'cancelled' => $cancelled,
            'revenue' => $revenue ?: 0
        ];
    }

    /**
     * Calculate percentage trend
     */
    private function calculateTrend($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Get recent bookings for dashboard
     */
    // public function getRecentBookings(Request $request)
    // {
    //     $limit = $request->input('limit', 10);

    //     $bookings = Booking::with(['customer', 'vehicle'])
    //         ->orderBy('created_at', 'desc')
    //         ->limit($limit)
    //         ->get()
    //         ->map(function ($booking) {
    //             return [
    //                 'id' => $booking->id,
    //                 'customer_name' => $booking->customer->name ?? 'N/A',
    //                 'vehicle_name' => $booking->vehicle->name ?? 'N/A',
    //                 'status' => $booking->status,
    //                 'total_amount' => $booking->total_amount,
    //                 'created_at' => $booking->created_at->format('M d, Y H:i'),
    //                 'status_badge' => $this->getStatusBadge($booking->status)
    //             ];
    //         });

    //     return response()->json([
    //         'status' => true,
    //         'bookings' => $bookings
    //     ]);
    // }

    /**
     * Get status badge class
     */
    private function getStatusBadge($status)
    {
        $badges = [
            'pending' => 'bg-warning',
            'confirmed' => 'bg-info',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger'
        ];

        return $badges[$status] ?? 'bg-secondary';
    }
}