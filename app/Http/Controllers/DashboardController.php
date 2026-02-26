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
     * Get quarterly analytics data
     */
    public function getQuarterlyAnalytics(Request $request)
    {
        $request->validate([
            'quarter' => 'required|integer|between:1,4',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1)
        ]);

        $quarter = $request->input('quarter');
        $year = $request->input('year');

        try {
            // Define quarter months
            $quarterMonths = [
                1 => [1, 2, 3],   // Q1: Jan, Feb, Mar
                2 => [4, 5, 6],   // Q2: Apr, May, Jun
                3 => [7, 8, 9],   // Q3: Jul, Aug, Sep
                4 => [10, 11, 12] // Q4: Oct, Nov, Dec
            ];

            $monthsInQuarter = $quarterMonths[$quarter];
            $dates = ['Month 1', 'Month 2', 'Month 3'];
            
            // Prepare monthly data arrays
            $monthlyData = [
                'confirmed' => array_fill(0, 3, 0),
                'completed' => array_fill(0, 3, 0),
                'pending' => array_fill(0, 3, 0),
                'cancelled' => array_fill(0, 3, 0)
            ];

            // Query bookings for the selected quarter
            $bookings = Booking::whereYear('created_at', $year)
                ->whereIn(DB::raw('MONTH(created_at)'), $monthsInQuarter)
                ->get();

            // Process monthly counts
            foreach ($bookings as $booking) {
                $month = (int) $booking->created_at->format('n');
                $status = strtolower($booking->status);
                
                // Find which month in the quarter this belongs to
                $monthIndex = array_search($month, $monthsInQuarter);
                
                if ($monthIndex !== false && isset($monthlyData[$status][$monthIndex])) {
                    $monthlyData[$status][$monthIndex]++;
                }
            }

            // Get quarterly summary
            $summary = $this->getQuarterlySummary($quarter, $year);

            // Calculate trends (comparison with previous quarter)
            $previousQuarter = $quarter == 1 ? 4 : $quarter - 1;
            $previousYear = $quarter == 1 ? $year - 1 : $year;
            $previousSummary = $this->getQuarterlySummary($previousQuarter, $previousYear);

            $trends = [
                'confirmed_trend' => $this->calculateTrend($summary['confirmed'], $previousSummary['confirmed']),
                'completed_trend' => $this->calculateTrend($summary['completed'], $previousSummary['completed']),
                'revenue_trend' => $this->calculateTrend($summary['revenue'], $previousSummary['revenue']),
            ];

            // Get month names for display
            $monthNames = [];
            foreach ($monthsInQuarter as $month) {
                $monthNames[] = Carbon::create($year, $month)->format('M');
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'period_type' => 'quarterly',
                    'dates' => $monthNames,
                    'confirmed' => $monthlyData['confirmed'],
                    'completed' => $monthlyData['completed'],
                    'pending' => $monthlyData['pending'],
                    'cancelled' => $monthlyData['cancelled'],
                    'summary' => $summary,
                    'trends' => $trends,
                    'period_name' => "Q{$quarter} {$year} (" . implode(', ', $monthNames) . ")"
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch quarterly analytics data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get yearly analytics data
     */
    public function getYearlyAnalytics(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1)
        ]);

        $year = $request->input('year');

        try {
            $dates = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                     'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            // Prepare monthly data arrays
            $monthlyData = [
                'confirmed' => array_fill(0, 12, 0),
                'completed' => array_fill(0, 12, 0),
                'pending' => array_fill(0, 12, 0),
                'cancelled' => array_fill(0, 12, 0)
            ];

            // Query bookings for the selected year
            $bookings = Booking::whereYear('created_at', $year)->get();

            // Process monthly counts
            foreach ($bookings as $booking) {
                $month = (int) $booking->created_at->format('n') - 1; // 0-based index
                $status = strtolower($booking->status);

                if (isset($monthlyData[$status][$month])) {
                    $monthlyData[$status][$month]++;
                }
            }

            // Get yearly summary
            $summary = $this->getYearlySummary($year);

            // Calculate trends (comparison with previous year)
            $previousYear = $year - 1;
            $previousSummary = $this->getYearlySummary($previousYear);

            $trends = [
                'confirmed_trend' => $this->calculateTrend($summary['confirmed'], $previousSummary['confirmed']),
                'completed_trend' => $this->calculateTrend($summary['completed'], $previousSummary['completed']),
                'revenue_trend' => $this->calculateTrend($summary['revenue'], $previousSummary['revenue']),
            ];

            return response()->json([
                'status' => true,
                'data' => [
                    'period_type' => 'yearly',
                    'dates' => $dates,
                    'confirmed' => $monthlyData['confirmed'],
                    'completed' => $monthlyData['completed'],
                    'pending' => $monthlyData['pending'],
                    'cancelled' => $monthlyData['cancelled'],
                    'summary' => $summary,
                    'trends' => $trends,
                    'period_name' => "Year {$year}"
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch yearly analytics data',
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
     * Get quarterly summary
     */
    private function getQuarterlySummary($quarter, $year)
    {
        // Define quarter months
        $quarterMonths = [
            1 => [1, 2, 3],   // Q1: Jan, Feb, Mar
            2 => [4, 5, 6],   // Q2: Apr, May, Jun
            3 => [7, 8, 9],   // Q3: Jul, Aug, Sep
            4 => [10, 11, 12] // Q4: Oct, Nov, Dec
        ];

        $months = $quarterMonths[$quarter];
        
        // Create start and end dates for the quarter
        $startDate = Carbon::create($year, $months[0], 1)->startOfMonth();
        $endDate = Carbon::create($year, $months[2], 1)->endOfMonth();

        // Get status counts for the quarter
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

        // Get revenue from completed bookings in the quarter
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
     * Get yearly summary
     */
    private function getYearlySummary($year)
    {
        $startDate = Carbon::create($year, 1, 1)->startOfYear();
        $endDate = Carbon::create($year, 12, 31)->endOfYear();

        // Get status counts for the year
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

        // Get revenue from completed bookings in the year
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
    public function getRecentBookings(Request $request)
    {
        $limit = $request->input('limit', 10);

        $bookings = Booking::with(['vehicle:id,name','user:id,name'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($booking) { 
                return [
                    'voucher_number' => $booking->voucher_number,
                    'customer_name' => $booking->customer_name ?? 'N/A',
                    'vehicle_name' => optional($booking->vehicle)->name ?? 'N/A',
                    'total_amount' => $booking->total_amount,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at->format('M d, Y H:i'),
                    'status_badge' => $this->getStatusBadge($booking->status),
                    'created_by_name' => optional($booking->user)->name ?? 'System',
                ];
            });

        return response()->json([
            'status' => true,
            'bookings' => $bookings
        ]);
    }

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