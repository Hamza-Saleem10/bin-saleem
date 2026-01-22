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
        // Check if this is a datatable AJAX request
        if ($request->ajax()) {
            $query = Attendance::with(['user:id,name', 'location'])->get();

            return DataTables::of($query)
                ->addColumn('check_in', function ($attendance) {
                    if ($attendance->check_in) {
                        if ($attendance->check_in instanceof \Carbon\Carbon) {
                            return $attendance->check_in->format('h:i A');
                        } else {
                            return \Carbon\Carbon::parse($attendance->check_in)->format('h:i A');
                        }
                    }
                    return 'N/A';
                })
                ->addColumn('check_out', function ($attendance) {
                    if ($attendance->check_out) {
                        if ($attendance->check_out instanceof \Carbon\Carbon) {
                            return $attendance->check_out->format('h:i A');
                        } else {
                            return \Carbon\Carbon::parse($attendance->check_out)->format('h:i A');
                        }
                    }
                    return 'N/A';
                })
                ->addColumn('status', function ($attendance) {
                    $status = $attendance->status ?? 'Unmarked';
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
                    }

                    return '<span class="badge ' . $badgeClass . '">' . $status . '</span>';
                })
                ->addColumn('location', function ($attendance) {
                    return $attendance->location->location_name ?? 'N/A';
                })
                ->addColumn('action', function ($attendance) {
                    $actions = '<div class="overlay-edit d-flex">';
                    
                    if (auth()->user()->can('Delete Attendance')) {
                        $actions .= '<a href="' . route('attendance.destroy', $attendance->uuid) . '" class="btn btn-icon btn-danger btn-delete">
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
                    'status' => 'pending' // Will be updated later
                ]);
            }

            // Update check_in time
            $attendance->update([
                'check_in' => now()
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

        // Validate location
        $rule = AttendanceRule::where('is_active', true)->first();
        if ($rule && !$this->isWithinAllowedRadius($request->latitude, $request->longitude, $rule)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not within the allowed area for attendance'
            ], 400);
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

        // Update attendance status based on rules
        if ($rule) {
            $status = $this->determineStatus($type, $attendance, $rule);
            $attendance->update(['status' => $status]);
        } else {
            $attendance->update(['status' => 'present']);
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $type)) . ' successful',
            'data' => [
                'attendance' => $attendance->load('location'),
                'check_in_time' => $attendance->check_in ? $attendance->check_in->format('h:i A') : null,
                'check_out_time' => $attendance->check_out ? $attendance->check_out->format('h:i A') : null,
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

        return response()->json([
            'success' => true,
            'data' => $attendance
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
        // Default radius if no rule exists
        $radius = $rule ? $rule->location_radius : 100; // meters

        // Get reference location from rule (you might want to add this to rules table)
        $refLat = config('attendance.reference_latitude', 0);
        $refLon = config('attendance.reference_longitude', 0);

        $distance = $this->calculateDistance($lat1, $lon1, $refLat, $refLon);

        return $distance <= $radius;
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
        // For check-out, status is already determined at check-in
        if ($type === 'check_out') {
            return $attendance->status ?? 'present';
        }

        if (!$rule) {
            return 'present';
        }

        // Check if check-in is late
        $checkInTime = $attendance->check_in;
        $ruleCheckInTime = now()->setTimeFromTimeString($rule->check_in_time);
        $lateTime = $ruleCheckInTime->addMinutes($rule->late_threshold);

        return $checkInTime->greaterThan($lateTime) ? 'late' : 'present';
    }
}