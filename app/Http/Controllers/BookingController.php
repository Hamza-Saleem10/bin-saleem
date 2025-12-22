<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use Yajra\DataTables\DataTables;
use App\Models\BookingsFlightDetail;
use App\Models\BookingsHotelDetail;
use App\Models\BookingsRouteDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bookings = Booking::with(['vehicle:id,name']);

            return DataTables::of($bookings)
                ->addColumn('is_active', function ($booking) {
                    return getStatusBadge($booking->is_active);
                })
                ->addColumn('action', function ($booking) {
                    $actions = '<div class="overlay-edit d-flex">';

                    if (auth()->user()->can('Update Booking')) {
                        $actions .= '<a href="' . route('bookings.edit', $booking->uuid) . '" class="btn btn-icon btn-secondary me-1" title="Edit"><i class="feather icon-edit-2"></i></a>';
                    }

                    if (auth()->user()->can('Update Booking Status')) {
                        $actions .= '<a href="' . route('bookings.updateStatus', $booking->uuid) . '" class="btn btn-icon ' . ($booking->status == 'active' ? 'btn-danger' : 'btn-success') . ' btn-status me-1" title="Change Status">' .
                            '<i class="feather ' . ($booking->status == 'active' ? 'icon-x-circle' : 'icon-check-circle') . '"></i></a>';
                    }

                    if (auth()->user()->can('Delete Booking')) {
                        $actions .= '<a href="' . route('bookings.destroy', $booking->uuid) . '" class="btn btn-icon btn-danger btn-delete" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="feather icon-trash-2"></i></a>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('bookings.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles = Vehicle::active()->pluck('name', 'id');
        return view('bookings.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validate all input data
        $validated = $request->validate([
            // Basic fields remain the same
            'customer_name' => 'required|string|max:191',
            'customer_email' => 'nullable|email|max:191',
            'customer_contact' => 'required|string|max:15',
            'adult_person' => 'nullable|integer|min:0',
            'child_person' => 'nullable|integer|min:0',
            'infant_person' => 'nullable|integer|min:0',
            'number_of_pax' => 'required|integer|min:0',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',

            // ARRAY VALIDATION for hotel details
            'city' => 'required|array|min:1',
            'city.*' => 'required|string|max:191',
            'hotel_name' => 'required|array|min:1',
            'hotel_name.*' => 'required|string|max:255',
            'check_in_date' => 'required|array|min:1',
            'check_in_date.*' => 'nullable|date|after_or_equal:today',
            'check_out_date' => 'required|array|min:1',
            'check_out_date.*' => 'nullable|date|after:check_in_date.*',
            'duration' => 'nullable|array',
            'duration.*' => 'nullable|string',

            // ARRAY VALIDATION for flight details
            'flight_code' => 'nullable|array',
            'flight_code.*' => 'nullable|string|max:50',
            'flight_from' => 'nullable|array',
            'flight_from.*' => 'nullable|string|max:20',
            'flight_to' => 'nullable|array',
            'flight_to.*' => 'nullable|string|max:20',
            'flight_date' => 'nullable|array',
            'flight_date.*' => 'nullable|date|after_or_equal:today',
            'departure_time' => 'nullable|array',
            'departure_time.*' => 'nullable|date_format:H:i',
            'arrival_time' => 'nullable|array',
            'arrival_time.*' => 'nullable|date_format:H:i|after:departure_time.*',

            // ARRAY VALIDATION for route details
            'pick_up' => 'required|array|min:1',
            'pick_up.*' => 'required|string|max:191',
            'pickup_date' => 'required|array|min:1',
            'pickup_date.*' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|array|min:1',
            'pickup_time.*' => 'required|date_format:H:i',
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

        // Start database transaction
        DB::beginTransaction();

        try {
            // Calculate number of pax automatically if not provided
            if (empty($validated['number_of_pax'])) {
                $validated['number_of_pax'] =
                    ($validated['adult_person'] ?? 0) +
                    ($validated['child_person'] ?? 0) +
                    ($validated['infant_person'] ?? 0);
            }

            // Set default status if not provided
            if (!isset($validated['status'])) {
                $validated['status'] = 'pending';
            }

            // Extract main booking data (non-array fields)
            $bookingData = [
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_contact' => $validated['customer_contact'],
                'adult_person' => $validated['adult_person'] ?? 0,
                'child_person' => $validated['child_person'] ?? 0,
                'infant_person' => $validated['infant_person'] ?? 0,
                'number_of_pax' => $validated['number_of_pax'],
                'status' => $validated['status'],
            ];

            // Create the main booking record
            $booking = Booking::create($bookingData);

            // Create Hotel Details Records (Multiple)
            foreach ($validated['city'] as $index => $city) {
                // Calculate duration if not provided
                $duration = $validated['duration'][$index] ?? null;
                if (empty($duration) && isset($validated['check_in_date'][$index]) && isset($validated['check_out_date'][$index])) {
                    $checkIn = Carbon::parse($validated['check_in_date'][$index]);
                    $checkOut = Carbon::parse($validated['check_out_date'][$index]);
                    $duration = $checkOut->diffInDays($checkIn);
                }

                BookingsHotelDetail::create([
                    'booking_id' => $booking->id,
                    'city' => $city,
                    'hotel_name' => $validated['hotel_name'][$index],
                    'check_in_date' => $validated['check_in_date'][$index] ?? null,
                    'check_out_date' => $validated['check_out_date'][$index] ?? null,
                    'duration' => $duration,
                ]);
            }

            // Create Flight Details Records (Multiple - if provided)
            if (isset($validated['flight_code']) && count($validated['flight_code']) > 0) {
                foreach ($validated['flight_code'] as $index => $flightCode) {
                    // Only create if at least one flight field is provided
                    if (!empty($flightCode) || !empty($validated['flight_from'][$index]) || !empty($validated['flight_to'][$index])) {
                        BookingsFlightDetail::create([
                            'booking_id' => $booking->id,
                            'flight_code' => $flightCode ?? null,
                            'flight_from' => $validated['flight_from'][$index] ?? null,
                            'flight_to' => $validated['flight_to'][$index] ?? null,
                            'flight_date' => $validated['flight_date'][$index] ?? null,
                            'departure_time' => $validated['departure_time'][$index] ?? null,
                            'arrival_time' => $validated['arrival_time'][$index] ?? null,
                        ]);
                    }
                }
            }

            // Create Route Details Records (Multiple)
            foreach ($validated['pick_up'] as $index => $pickUp) {
                BookingsRouteDetail::create([
                    'booking_id' => $booking->id,
                    'pick_up' => $pickUp,
                    'pickup_date' => $validated['pickup_date'][$index],
                    'pickup_time' => $validated['pickup_time'][$index],
                    'vehicle_id' => $validated['vehicle_id'],
                ]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('bookings.index')
                ->with('success', 'Booking created successfully!');

        } catch (\Exception $e) {
            DB::rollback();

            // For debugging, show the actual error
            // return back()->withInput()->with('error', 'Failed to create booking: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to create booking. Please try again.');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $vehicles = Vehicle::active()->pluck('name', 'id');
        return view('bookings.edit', get_defined_vars());
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeeStructureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_contact' => 'required|string',
            'vehicle' => 'required|string|max:255',
            'pickup' => 'required|string|max:255',
            'dropoff' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $data['customer_contact'] = $request->customer_contact;

        $booking->update($data);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return back()->with('success', 'Booking deleted Successfully.');
    }

    public function updateStatus($uuid)
    {
        $booking = Booking::uuid($uuid)->first();

        if ($booking) {
            $booking->is_active = !$booking->is_active;
            $booking->save();

            return $this->sendResponse(true, __('messages.booking_update'));
        }
        return $this->sendResponse(false, __('messages.booking_not_found'), [], 404);
    }
}
