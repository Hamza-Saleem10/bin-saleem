<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceLocation;
use App\Models\AttendanceRule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get month from request or use current month
            $month = $request->get('m', date('Y-m'));
            $year = date('Y', strtotime($month));
            $monthNum = date('m', strtotime($month));

            // Parse the month to get start and end dates
            $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
            $endDate = \Carbon\Carbon::parse($month)->endOfMonth();

            // Get all users with their attendance for the selected month
            $query = User::select('id', 'name')
                ->with([
                    'attendances' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('date', [$startDate, $endDate]);
                    }
                ]);

            return DataTables::of($query)
                ->addColumn('check_in', function ($user) use ($month) {
                    // Get today's attendance check-in
                    $today = date('Y-m-d');
                    $todayAttendance = $user->attendances->where('date', $today)->first();

                    if ($todayAttendance && $todayAttendance->check_in) {
                        return \Carbon\Carbon::parse($todayAttendance->check_in)->format('h:i A');
                    }
                    return 'N/A';
                })
                ->addColumn('check_out', function ($user) use ($month) {
                    // Get today's attendance check-out
                    $today = date('Y-m-d');
                    $todayAttendance = $user->attendances->where('date', $today)->first();

                    if ($todayAttendance && $todayAttendance->check_out) {
                        return \Carbon\Carbon::parse($todayAttendance->check_out)->format('h:i A');
                    }
                    return 'N/A';
                })
                ->addColumn('status', function ($user) use ($month) {
                    // Get today's attendance status
                    $today = date('Y-m-d');
                    $todayAttendance = $user->attendances->where('date', $today)->first();
                    $status = $todayAttendance->status ?? 'Unmarked';
                    $status = ucfirst($status);
                    $badgeClass = 'badge-light';

                    if ($status === 'Present') {
                        $badgeClass = 'bg-success';
                    } elseif ($status === 'Absent') {
                        $badgeClass = 'bg-danger';
                    } elseif ($status === 'Late') {
                        $badgeClass = 'bg-warning';
                    } elseif ($status === 'Halfday') {
                        $badgeClass = 'bg-info';
                    } elseif ($status === 'Holiday' || $status === 'Leave') {
                        $badgeClass = 'bg-primary';
                    } elseif ($status === 'Unmarked') {
                        $badgeClass = 'bg-secondary';
                    }

                    return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
                })
                ->addColumn('location', function ($user) use ($month) {
                    // Get today's location
                    $today = date('Y-m-d');
                    $todayAttendance = $user->attendances->where('date', $today)->first();
                    return $todayAttendance->location->location_name ?? 'N/A';
                })
                ->addColumn('total_days', function ($user) use ($startDate, $endDate) {
                    // Calculate total days in the month
                    return $startDate->daysInMonth;
                })
                ->addColumn('holidays', function ($user) use ($startDate, $endDate) {
                    // Count Sundays in the month
                    $holidays = 0;
                    $currentDate = $startDate->copy();

                    while ($currentDate <= $endDate) {
                        if ($currentDate->isSunday()) {
                            $holidays++;
                        }
                        $currentDate->addDay();
                    }

                    return $holidays;
                })
                ->addColumn('working_days', function ($user) use ($startDate, $endDate) {
                    // Total days minus Sundays (holidays)
                    $totalDays = $startDate->daysInMonth;

                    // Count Sundays
                    $holidays = 0;
                    $currentDate = $startDate->copy();
                    while ($currentDate <= $endDate) {
                        if ($currentDate->isSunday()) {
                            $holidays++;
                        }
                        $currentDate->addDay();
                    }

                    return $totalDays - $holidays;
                })
                ->addColumn('present', function ($user) {
                    // Count present days from user's attendance records
                    return $user->attendances->where('status', 'Present')->count();
                })
                ->addColumn('absent', function ($user) use ($startDate, $endDate) {
                    // Calculate absent days = Working days - Present days
                    $totalDays = $startDate->daysInMonth;

                    // Count Sundays
                    $holidays = 0;
                    $currentDate = $startDate->copy();
                    while ($currentDate <= $endDate) {
                        if ($currentDate->isSunday()) {
                            $holidays++;
                        }
                        $currentDate->addDay();
                    }

                    $workingDays = $totalDays - $holidays;
                    $presentDays = $user->attendances->where('status', 'Present')->count();
                    $absentDays = $workingDays - $presentDays;

                    return max(0, $absentDays);
                })
                ->addColumn('action', function ($user) {
                    $actions = '<div class="overlay-edit d-flex">';

                    if (auth()->user()->can('View Attendance')) {
                        $actions .= '<button class="btn btn-icon btn-info btn-view-attendance" 
                        data-user-id="' . $user->id . '" 
                        data-user-name="' . htmlspecialchars($user->name) . '"
                        title="View Details">
                        <i class="feather icon-eye"></i></button>';
                    }

                    if (auth()->user()->can('Delete Attendance')) {
                        $actions .= '<a href="' . route('attendance.user.destroy', $user->id) . '" 
                        class="btn btn-icon btn-danger btn-delete ml-1"
                        title="Delete Attendance">
                        <i class="feather icon-trash-2"></i></a>';
                    }
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        $users = User::select('id', 'name')->get();
        return view('attendance.index', get_defined_vars());
    }

    public function getUserAttendanceDetails(Request $request)
    {
        try {
            $userId = $request->get('user_id');
            $month = $request->get('m', date('Y-m'));

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required'
                ], 400);
            }

            $user = User::findOrFail($userId);
            $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
            $endDate = \Carbon\Carbon::parse($month)->endOfMonth();

            // Get all dates in the month
            $dates = [];
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            // Get attendance records for this user and month
            $attendanceRecords = Attendance::with('location')
                ->where('user_id', $userId)
                ->whereBetween('date', [$startDate, $endDate])
                ->get()
                ->keyBy('date');

            // Prepare attendance data for all days in month
            $attendanceData = [];
            $presentCount = 0;
            $absentCount = 0;
            $lateCount = 0;
            $halfDayCount = 0;
            $holidays = 0;

            foreach ($dates as $date) {
                $carbonDate = \Carbon\Carbon::parse($date);
                $isSunday = $carbonDate->isSunday();

                if ($isSunday) {
                    $holidays++;
                }

                $record = $attendanceRecords->get($date);

                if ($record) {
                    $status = strtolower($record->status);

                    if ($status === 'present') {
                        $presentCount++;
                    } elseif ($status === 'absent') {
                        $absentCount++;
                    } elseif ($status === 'late') {
                        $lateCount++;
                        $presentCount++; // Late is also considered present
                    } elseif ($status === 'halfday' || $status === 'half_day') {
                        $halfDayCount++;
                        $presentCount += 0.5;
                    }

                    $attendanceData[] = [
                        'date' => $date,
                        'check_in' => $record->check_in,
                        'check_out' => $record->check_out,
                        'status' => ucfirst($record->status),
                        'location_name' => $record->location->location_name ?? null,
                        'is_sunday' => $isSunday
                    ];
                } else {
                    // No attendance record for this day
                    $attendanceData[] = [
                        'date' => $date,
                        'check_in' => null,
                        'check_out' => null,
                        'status' => $isSunday ? 'Holiday' : 'Absent',
                        'location_name' => null,
                        'is_sunday' => $isSunday
                    ];

                    if (!$isSunday) {
                        $absentCount++;
                    }
                }
            }

            // Calculate summary
            $totalDays = $startDate->daysInMonth;
            $workingDays = $totalDays - $holidays;

            return response()->json([
                'success' => true,
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'month' => $month,
                    'total_days' => $totalDays,
                    'holidays' => $holidays,
                    'working_days' => $workingDays,
                    'present_count' => $presentCount,
                    'absent_count' => $absentCount,
                    'late_count' => $lateCount,
                    'half_day_count' => $halfDayCount,
                    'attendance' => $attendanceData
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching user attendance details: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to load attendance details: ' . $e->getMessage()
            ], 500);
        }
    }

    public static function calculateAttendanceSummary($userId, $month)
    {
        $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
        $endDate = \Carbon\Carbon::parse($month)->endOfMonth();

        // Get user's attendance for the month
        $attendances = Attendance::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Total days in month
        $totalDays = $startDate->daysInMonth;

        // Count Sundays
        $holidays = 0;
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            if ($currentDate->isSunday()) {
                $holidays++;
            }
            $currentDate->addDay();
        }

        // Working days
        $workingDays = $totalDays - $holidays;

        // Present days
        $presentDays = $attendances->where('status', 'Present')->count();

        // Absent days
        $absentDays = $workingDays - $presentDays;

        return [
            'total_days' => $totalDays,
            'holidays' => $holidays,
            'working_days' => $workingDays,
            'present' => $presentDays,
            'absent' => max(0, $absentDays),
        ];
    }

    public static function getMonthlyHolidays($month)
    {
        $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
        $endDate = \Carbon\Carbon::parse($month)->endOfMonth();

        $holidays = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            if ($currentDate->isSunday()) {
                $holidays[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        return $holidays;
    }

    public function markAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:check_in,check_out',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $type = $request->type;
        $today = now()->toDateString();

        // Get user's attendance rule
        $rule = $user->attendanceRule()->active()->first();

        // Initialize compliance flags
        $isTimeCompliant = true;
        $isLocationCompliant = true;
        $complianceMessage = '';

        // Check time compliance only for check-in
        if ($type === 'check_in' && $rule) {
            $ruleCheckInTime = \Carbon\Carbon::parse($today . ' ' . $rule->check_in_time);
            $currentTime = now();

            // Time is compliant if check-in is before or exactly at scheduled time
            if ($currentTime->greaterThan($ruleCheckInTime)) {
                $isTimeCompliant = false;
                $complianceMessage = 'Checked in after scheduled time';
            }
        }

        // Validate location if rule exists
        if ($rule && !$this->isWithinAllowedRadius($request->latitude, $request->longitude, $rule)) {
            $isLocationCompliant = false;
            if ($complianceMessage) {
                $complianceMessage .= ' and outside allowed area';
            } else {
                $complianceMessage = 'Outside allowed area';
            }
        }

        // Check if attendance record exists for today
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($type === 'check_in') {
            // Check for duplicate check-in
            if ($attendance && $attendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already checked in today'
                ], 400);
            }

            // Create attendance record if doesn't exist
            if (!$attendance) {
                $attendance = Attendance::create([
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'user_id' => $user->id,
                    'date' => $today,
                    'status' => 'pending'
                ]);
            }

            // Update check_in time
            $attendance->update([
                'check_in' => now(),
                'status' => 'present', // Always present
                'is_time_compliant' => $isTimeCompliant,
                'is_location_compliant' => $isLocationCompliant,
                'compliance_message' => $complianceMessage
            ]);

        } else if ($type === 'check_out') {
            // Check if check-in exists
            if (!$attendance || !$attendance->check_in) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must check in before checking out'
                ], 400);
            }

            // Check for duplicate check-out
            if ($attendance && $attendance->check_out) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already checked out today'
                ], 400);
            }

            // Update check_out time
            $attendance->update([
                'check_out' => now()
            ]);
        }

        // Get location name
        $locationName = $this->getLocationName($request->latitude, $request->longitude);

        // Create or update attendance location record
        $locationData = [
            'uuid' => \Illuminate\Support\Str::uuid(),
            'attendance_id' => $attendance->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location_name' => $locationName,
            'ip_address' => $request->ip(),
            'device_info' => $request->userAgent(),
        ];

        // If location already exists for this attendance, update it
        $existingLocation = AttendanceLocation::where('attendance_id', $attendance->id)->first();
        if ($existingLocation) {
            $existingLocation->update($locationData);
        } else {
            AttendanceLocation::create($locationData);
        }

        // Get rule times for response
        $ruleTimes = null;
        if ($rule) {
            $ruleTimes = [
                'check_in_time' => $rule->check_in_time,
                'check_out_time' => $rule->check_out_time,
                'is_time_compliant' => $isTimeCompliant,
                'is_location_compliant' => $isLocationCompliant,
                'compliance_message' => $complianceMessage
            ];
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $type)) . ' successful',
            'data' => [
                'attendance' => $attendance->load('location'),
                'check_in_time' => $attendance->check_in ? $attendance->check_in->format('h:i A') : null,
                'check_out_time' => $attendance->check_out ? $attendance->check_out->format('h:i A') : null,
                'status' => $attendance->status,
                'rule_times' => $ruleTimes
            ]
        ]);
    }

    public function getTodayAttendance()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $attendance = Attendance::with('location')
            ->where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        // Fetch user's currently active attendance rule (if any)
        $rule = $user->attendanceRule()->active()->first();

        // Limit rule payload to the fields needed on the frontend
        $ruleData = $rule ? [
            'id' => $rule->id,
            'name' => $rule->name,
            'check_in_time' => $rule->check_in_time,
            'check_out_time' => $rule->check_out_time,
            'late_threshold' => $rule->late_threshold,
            'location_radius' => $rule->location_radius,
            'allowed_locations' => $rule->allowed_locations,
            'is_active' => $rule->is_active,
        ] : null;

        return response()->json([
            'success' => true,
            'data' => $attendance,
            'rule' => $ruleData,
        ]);
    }

    private function getLocationName($latitude, $longitude)
    {
        // Using OpenStreetMap Nominatim (free, no API key required)
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}&zoom=18&addressdetails=1";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourApp/1.0');

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['display_name'])) {
                return $data['display_name'];
            }
        }

        return "Location: {$latitude}, {$longitude}";
    }

    private function isWithinAllowedRadius($lat1, $lon1, $rule)
    {
        if (!$rule) {
            return true; // No rule means no restriction
        }

        $radius = $rule->location_radius;
        $allowedLocations = $rule->allowed_locations ?? [];

        if (empty($allowedLocations)) {
            return true; // No specific locations set
        }

        foreach ($allowedLocations as $location) {
            $distance = $this->calculateDistance(
                $lat1,
                $lon1,
                $location['latitude'],
                $location['longitude']
            );

            if ($distance <= $radius) {
                return true;
            }
        }

        return false;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    private function determineStatus($type, $attendance, $rule)
    {
        if (!$rule) {
            return 'present';
        }

        if ($type === 'check_in') {
            $checkInTime = $attendance->check_in;
            $ruleCheckInTime = \Carbon\Carbon::parse($attendance->date . ' ' . $rule->check_in_time);

            // Check if check-in is before or at the scheduled time
            if ($checkInTime->lessThanOrEqualTo($ruleCheckInTime)) {
                return 'present';
            } else {
                // Even if late, we still return 'present' but with different status code
                return 'present'; // But we'll handle the color differently in frontend
            }
        }

        if ($type === 'check_out') {
            // For check-out, always return present
            return 'present';
        }

        return 'present';
    }
    public function getMonthlyAttendance(Request $request)
{
    $month = $request->input('month', date('n'));
    $year = $request->input('year', date('Y'));

    // Parse month and year to get start and end dates
    $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
    $endDate = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();

    $attendance = Attendance::where('user_id', auth()->id())
        ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
        ->get()
        ->mapWithKeys(function ($item) {
            // Use the date as key
            $dateKey = \Carbon\Carbon::parse($item->date)->format('Y-m-d');
            
            return [
                $dateKey => [
                    'check_in' => $item->check_in ? \Carbon\Carbon::parse($item->check_in)->format('H:i:s') : null,
                    'check_out' => $item->check_out ? \Carbon\Carbon::parse($item->check_out)->format('H:i:s') : null,
                    'status' => $item->status,
                    'location_in' => $item->location_in,
                    'location_out' => $item->location_out,
                    'date' => $dateKey
                ]
            ];
        });

    return response()->json([
        'success' => true,
        'data' => $attendance
    ]);
}
}