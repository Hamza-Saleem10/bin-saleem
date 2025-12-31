<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $vehicles = Vehicle::with('media')->get();

            return DataTables::of($vehicles)
                ->addColumn('is_active', function ($vehicle) {
                    return getStatusBadge($vehicle->is_active);
                })
                ->addColumn('image_url', function ($vehicle) {
                    return $vehicle->getImageUrlAttribute();
                })
                ->addColumn('action', function ($vehicle) {
                    $actions = '<div class="overlay-edit d-flex">';

                    if (auth()->user()->can('Update Vehicle')) {
                        $actions .= '<a href="' . route('vehicles.edit', $vehicle->uuid) . '" class="btn btn-icon btn-secondary me-1" title="Edit"><i class="feather icon-edit-2"></i></a>';
                    }
                    if (auth()->user()->can('Update Vehicle Status')) {
                        $actions .= '<a href="' . route('vehicles.updateStatus', $vehicle->uuid) . '" class="btn btn-icon ' . ($vehicle->is_active == 1 ? 'btn-danger' : 'btn-success') . ' btn-status me-1">' . '<i class="feather ' . ($vehicle->is_active == 1 ? 'icon-eye-off' : 'icon-eye') . '"></i></a>';
                    }
                    if (auth()->user()->can('Delete Vehicle')) {
                        $actions .= '<a href="' . route('vehicles.destroy', $vehicle->uuid) . '" class="btn btn-icon btn-danger btn-delete" title="Delete"><i class="feather icon-trash-2"></i></a>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }
        return view('vehicles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:50',
            'bags_capacity' => 'required|integer|min:0|max:50',
            'features' => 'nullable|string',
            'vehicle_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        // Handle features as JSON
        if ($request->filled('features')) {
            $features = array_map('trim', explode(',', $request->features));
            $data['features'] = json_encode(array_filter($features));
        } else {
            $data['features'] = null;
        }

        // Remove vehicle_image from data array before creating vehicle
        unset($data['vehicle_image']);

        // Create the vehicle record
        $vehicle = Vehicle::create($data);

        // Handle image upload via Media Library
        if ($request->hasFile('vehicle_image')) {
            $vehicle->addMediaFromRequest('vehicle_image')
                ->toMediaCollection('vehicles');
        }

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:50',
            'bags_capacity' => 'required|integer|min:0|max:50',
            'features' => 'nullable|string',
            'vehicle_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        // Features handling
        if ($request->filled('features')) {
            $data['features'] = array_filter(array_map('trim', explode(',', $request->features)));
        } else {
            $data['features'] = null;
        }

        // Handle image upload via Media Library
        if ($request->hasFile('vehicle_image')) {
            // Clear old images from the 'vehicles' collection and add the new one
            $vehicle->clearMediaCollection('vehicles');
            $vehicle->addMediaFromRequest('vehicle_image')
                ->toMediaCollection('vehicles');
        }

        // Remove vehicle_image from data array before updating
        unset($data['vehicle_image']);

        $data['is_active'] = $request->has('is_active');
        $vehicle->update($data);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            DB::beginTransaction();
            $vehicle->delete();

            DB::commit();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Vehicle deleted successfully!'
                ]);
            }
            return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting Vehicle: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('vehicles.index')->with('error', 'Error deleting Vehicle: ' . $e->getMessage());
        }
    }

    /**
     * Update Vehicle status (active/inactive)
     */
    public function updateStatus($uuid)
    {
        $vehicle = Vehicle::uuid($uuid)->first();
        if ($vehicle) {
            $vehicle->is_active = !$vehicle->is_active;
            $vehicle->save();

            return $this->sendResponse(true, __('messages.vehicle_update'));
        }
        return $this->sendResponse(false, __('messages.vehicle_not_found'), [], 404);
    }
}