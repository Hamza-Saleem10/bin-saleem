<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AttendanceRuleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AttendanceRule::with('users')->latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_badge', function ($rule) {
                    $status = $rule->is_active ? 'Active' : 'Inactive';
                    $badgeClass = $rule->is_active ? 'badge bg-success' : 'badge bg-danger';
                    return '<span class="' . $badgeClass . '">' . $status . '</span>';
                })
                ->addColumn('check_in_display', function ($rule) {
                    $checkInTime = \Carbon\Carbon::parse($rule->check_in_time);
                    $lateThreshold = $rule->late_threshold;
                    $lateTime = $checkInTime->copy()->addMinutes($lateThreshold);
                    
                    return $checkInTime->format('h:i A') . 
                           ' <small class="text-muted">(Late after: ' . $lateTime->format('h:i A') . ')</small>';
                })
                ->addColumn('check_out_display', function ($rule) {
                    return \Carbon\Carbon::parse($rule->check_out_time)->format('h:i A');
                })
                ->addColumn('users_count', function ($rule) {
                    return $rule->users()->count();
                })
                ->addColumn('action', function ($rule) {
                    $actions = '<div class="overlay-edit d-flex">';
                    
                    if (auth()->user()->can('Update Attendance Rule')) {
                        $actions .= '<button class="btn btn-icon btn-secondary me-1 btn-edit-rule" 
                            data-id="' . $rule->id . '" 
                            data-uuid="' . $rule->uuid . '"
                            data-name="' . htmlspecialchars($rule->name) . '"
                            data-check-in-time="' . $rule->check_in_time . '"
                            data-check-out-time="' . $rule->check_out_time . '"
                            data-late-threshold="' . $rule->late_threshold . '"
                            data-location-radius="' . $rule->location_radius . '"
                            data-allowed-locations="' . htmlspecialchars(json_encode($rule->allowed_locations ?? [])) . '"
                            data-is-active="' . $rule->is_active . '"
                            title="Edit Rule">
                            <i class="feather icon-edit-2"></i></button>';
                    }
                    
                    if (auth()->user()->can('Delete Attendance Rule')) {
                        $actions .= '<a href="' . route('attendance-rules.destroy', $rule->uuid) . '" class="btn btn-icon btn-danger btn-delete">
                        <i class="feather icon-trash-2"></i></a>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['status_badge', 'check_in_display', 'action'])
                ->make(true);
        }

        return view('attendance.attendance-rules.index');
    }

    public function create()
    {
        return view('attendance-rules.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'late_threshold' => 'required|integer|min:0',
            'location_radius' => 'required|numeric|min:0',
            'allowed_locations' => 'nullable|array',
            'allowed_locations.*.name' => 'required|string',
            'allowed_locations.*.latitude' => 'required|numeric',
            'allowed_locations.*.longitude' => 'required|numeric',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $rule = AttendanceRule::create([
                'name' => $request->name,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'late_threshold' => $request->late_threshold,
                'location_radius' => $request->location_radius,
                'allowed_locations' => $request->allowed_locations ?? [],
                'is_active' => $request->boolean('is_active')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Attendance rule created successfully!',
                'data' => $rule
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating rule: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($uuid)
    {
        $rule = AttendanceRule::where('uuid', $uuid)->firstOrFail();
        return response()->json($rule);
    }

    public function update(Request $request, $uuid)
    {
        $rule = AttendanceRule::where('uuid', $uuid)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'late_threshold' => 'required|integer|min:0',
            'location_radius' => 'required|numeric|min:0',
            'allowed_locations' => 'nullable|array',
            'allowed_locations.*.name' => 'required|string',
            'allowed_locations.*.latitude' => 'required|numeric',
            'allowed_locations.*.longitude' => 'required|numeric',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $rule->update([
                'name' => $request->name,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'late_threshold' => $request->late_threshold,
                'location_radius' => $request->location_radius,
                'allowed_locations' => $request->allowed_locations ?? [],
                'is_active' => $request->boolean('is_active')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Attendance rule updated successfully!',
                'data' => $rule
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating rule: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($uuid)
    {
        $rule = AttendanceRule::where('uuid', $uuid)->firstOrFail();

        // Check if rule is assigned to any users
        if ($rule->users()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete rule. It is assigned to ' . $rule->users()->count() . ' user(s).');
        }

        $rule->delete();

        return redirect()->route('attendance-rules.index')
            ->with('success', 'Attendance rule deleted successfully!');
    }

    public function toggleStatus($uuid)
    {
        $rule = AttendanceRule::where('uuid', $uuid)->firstOrFail();
        $rule->update(['is_active' => !$rule->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $rule->is_active
        ]);
    }
}