<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $bookings = Booking::with(['routeDetails:id,booking_id,vehicle_id,pick_up,pickup_date,pickup_time','routeDetails.vehicle:id,name']);

    //         return DataTables::of($bookings)
    //             ->addColumn('route_vehicle', function ($booking) {
    //                 return $booking->routeDetails
    //                     ->map(fn ($r) => optional($r->vehicle)->name)
    //                     ->implode(', ');
    //             })
    //             ->addColumn('pick_up', function ($booking) {
    //                 return $booking->routeDetails
    //                     ->pluck('pick_up')
    //                     ->implode(', ');
    //             })
    //             ->addColumn('pickup_date', function ($booking) {
    //                 return $booking->routeDetails
    //                     ->pluck('pickup_date')
    //                     ->implode(', ');
    //             })
    //             ->addColumn('pickup_time', function ($booking) {
    //                 return $booking->routeDetails
    //                     ->pluck('pickup_time')
    //                     ->implode(', ');
    //             })
    //             ->addColumn('is_active', function ($booking) {
    //                 return getStatusBadge($booking->is_active);
    //             })
    //             ->addColumn('action', function ($booking) {
    //                 $actions = '<div class="overlay-edit d-flex">';

    //                 if (auth()->user()->can('Update Booking')) {
    //                     $actions .= '<a href="' . route('bookings.edit', $booking->uuid) . '" class="btn btn-icon btn-secondary me-1" title="Edit"><i class="feather icon-edit-2"></i></a>';
    //                 }

    //                 if (auth()->user()->can('Update Booking Status')) {
    //                     $actions .= '<a href="' . route('bookings.updateStatus', $booking->uuid) . '" class="btn btn-icon ' . ($booking->status == 'active' ? 'btn-danger' : 'btn-success') . ' btn-status me-1" title="Change Status">' .
    //                         '<i class="feather ' . ($booking->status == 'active' ? 'icon-x-circle' : 'icon-check-circle') . '"></i></a>';
    //                 }

    //                 if (auth()->user()->can('Delete Booking')) {
    //                     $actions .= '<a href="' . route('bookings.destroy', $booking->uuid) . '" class="btn btn-icon btn-danger btn-delete" title="Delete"><i class="feather icon-trash-2"></i></a>';
    //                 }

    //                 $actions .= '</div>';
    //                 return $actions;
    //             })
    //             ->rawColumns(['is_active', 'action'])
    //             ->make(true);
    //     }

    //     return view('bookings.index');
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $routes = BookingsRouteDetail::with([
                'booking:id,uuid,voucher_number,customer_name,customer_contact,status,is_active',
                'vehicle:id,name'
            ]);

            return DataTables::of($routes)

                ->addColumn('voucher_number', fn($r) => $r->booking->voucher_number)
                ->addColumn('customer_name', fn($r) => $r->booking->customer_name)
                ->addColumn('customer_contact', fn($r) => $r->booking->customer_contact)

                ->addColumn('vehicle', fn($r) => optional($r->vehicle)->name)
                ->addColumn('pick_up', fn($r) => $r->pick_up)
                ->addColumn('pickup_date', fn($r) => $r->pickup_date)
                ->addColumn('pickup_time', fn($r) => $r->pickup_time)

                ->addColumn('status', fn($r) => $r->booking->status)
                // ->addColumn('status', fn($r) => getStatusBadge($r->booking->is_active))

                ->addColumn('action', function ($r) {
                    $booking = $r->booking;

                    $actions = '<div class="overlay-edit d-flex">';

                    if (auth()->user()->can('Update Booking')) {
                        $actions .= '<a href="' . route('bookings.edit', $booking->uuid) . '" class="btn btn-icon btn-secondary me-1">
                        <i class="feather icon-edit-2"></i></a>';
                    }

                    if (auth()->user()->can('View Booking Voucher')) {
                        $actions .= '<a href="' . route('bookings.bookingvoucher', $booking->uuid) . '" class="btn btn-icon btn-info me-1">
                        <i class="feather icon-eye"></i></a>';
                    }

                    if (auth()->user()->can('Delete Booking')) {
                        $actions .= '<a href="' . route('bookings.destroy', $booking->uuid) . '" class="btn btn-icon btn-danger btn-delete">
                        <i class="feather icon-trash-2"></i></a>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $request->search['value'] != '') {
                        $search = $request->search['value'];

                        $query->where(function ($q) use ($search) {
                            // Search in main table columns
                            $q->orWhere('pick_up', 'LIKE', "%{$search}%")
                                ->orWhere('pickup_date', 'LIKE', "%{$search}%")
                                ->orWhere('pickup_time', 'LIKE', "%{$search}%");

                            // Search in booking relationship
                            $q->orWhereHas('booking', function ($bookingQuery) use ($search) {
                                $bookingQuery->where('voucher_number', 'LIKE', "%{$search}%")
                                    ->orWhere('customer_name', 'LIKE', "%{$search}%")
                                    ->orWhere('customer_contact', 'LIKE', "%{$search}%")
                                    ->orWhere('status', 'LIKE', "%{$search}%");
                            });

                            // Search in vehicle relationship
                            $q->orWhereHas('vehicle', function ($vehicleQuery) use ($search) {
                                $vehicleQuery->where('name', 'LIKE', "%{$search}%");
                            });
                        });
                    }
                })

                ->orderColumn('pickup_date', function ($query, $order) {
                    $query->orderBy('pickup_date', $order);
                })
                ->orderColumn('voucher_number', function ($query, $order) {
                    $query->join('bookings', 'bookings.id', '=', 'bookings_route_details.booking_id')
                        ->orderBy('bookings.voucher_number', $order)
                        ->select('bookings_route_details.*');
                })
                ->orderColumn('customer_name', function ($query, $order) {
                    $query->join('bookings', 'bookings.id', '=', 'bookings_route_details.booking_id')
                        ->orderBy('bookings.customer_name', $order)
                        ->select('bookings_route_details.*');
                })
                ->orderColumn('status', function ($query, $order) {
                    $query->join('bookings', 'bookings.id', '=', 'bookings_route_details.booking_id')
                        ->orderBy('bookings.status', $order)
                        ->select('bookings_route_details.*');
                })

                ->rawColumns(['status', 'action'])
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
        $users = User::pluck('name', 'id');
        $vehicles = Vehicle::active()->pluck('name', 'id');

        return view('bookings.create', get_defined_vars());
    }
    /**
     * Display booking voucher with all booking details
     *
     * @param string $uuid
     * @return \Illuminate\Http\Response
     */
    public function bookingvoucher($uuid)
    {
        // Find booking with UUID and eager load all related details
        $booking = Booking::where('uuid', $uuid)
            ->with([
                'hotelDetails', // All hotel details
                'flightDetails', // All flight details  
                'routeDetails.vehicle', // All route details with vehicle info
                
            ])
            ->firstOrFail();
            
        $bookingByUser = User::find($booking->booking_by);

        // Calculate totals
        $totalHotels = $booking->hotelDetails->count();
        $totalFlights = $booking->flightDetails->count();
        $totalRoutes = $booking->routeDetails->count();

        // Calculate total duration for hotels
        $totalHotelNights = 0;
        foreach ($booking->hotelDetails as $hotel) {
            if ($hotel->check_in_date && $hotel->check_out_date) {
                $checkIn = Carbon::parse($hotel->check_in_date);
                $checkOut = Carbon::parse($hotel->check_out_date);
                $totalHotelNights += $checkOut->diffInDays($checkIn);
            }
        }

        // Get all unique vehicles used in routes
        $vehicles = $booking->routeDetails->map(function ($route) {
            return optional($route->vehicle)->name;
        })->filter()->unique()->implode(', ');
        

        return view('bookings.partials.booking-voucher', get_defined_vars());
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
            'customer_contact_full' => 'required|regex:/^\+[1-9]\d{1,14}$/',
            'booking_by' => 'required|exists:users,id',
            'adult_person' => 'nullable|integer|min:0',
            'child_person' => 'nullable|integer|min:0',
            'infant_person' => 'nullable|integer|min:0',
            'number_of_pax' => 'required|integer|min:0',
            // 'date_field_name' => 'required|date',
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
            'vehicle_id' => 'required|array|min:1',
            'vehicle_id.*' => 'required|exists:vehicles,id',
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
            $fullContactNumber = $request->input('customer_contact_full');
            if (empty($fullContactNumber)) {
                return back()->withErrors(['customer_contact' => 'Please enter a valid contact number.'])->withInput();
            }

            // Extract main booking data (non-array fields)
            $bookingData = [
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_contact' => $fullContactNumber,
                'booking_by' => $validated['booking_by'] ?? auth()->id(),
                'adult_person' => $validated['adult_person'] ?? 0,
                'child_person' => $validated['child_person'] ?? 0,
                'infant_person' => $validated['infant_person'] ?? 0,
                'number_of_pax' => $validated['number_of_pax'],
                // 'date_field_name' => $validated['date_field_name'],
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
                    'vehicle_id' => $validated['vehicle_id'][$index]
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
        $users = User::pluck('name', 'id');
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
        // Validate all input data (same as store)
        $validated = $request->validate([
            // Basic fields
            'customer_name' => 'required|string|max:191',
            'customer_email' => 'nullable|email|max:191',
            'customer_contact_full' => 'required|regex:/^\+[1-9]\d{1,14}$/',
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
            'check_in_date.*' => 'nullable|date',
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
            'flight_date.*' => 'nullable|date',
            'departure_time' => 'nullable|array',
            'departure_time.*' => 'nullable|date_format:H:i',
            'arrival_time' => 'nullable|array',
            'arrival_time.*' => 'nullable|date_format:H:i|after:departure_time.*',

            // ARRAY VALIDATION for route details
            'pick_up' => 'required|array|min:1',
            'pick_up.*' => 'required|string|max:191',
            'pickup_date' => 'required|array|min:1',
            'pickup_date.*' => 'required|date',
            'pickup_time' => 'required|array|min:1',
            'pickup_time.*' => 'required|date_format:H:i',
            'vehicle_id' => 'required|array|min:1',
            'vehicle_id.*' => 'required|exists:vehicles,id',
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
                $validated['status'] = $booking->status; // Keep existing status
            }

            $fullContactNumber = $request->input('customer_contact_full');
            if (empty($fullContactNumber)) {
                return back()->withErrors(['customer_contact' => 'Please enter a valid contact number.'])->withInput();
            }

            // Extract main booking data
            $bookingData = [
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_contact' => $fullContactNumber,
                'adult_person' => $validated['adult_person'] ?? 0,
                'child_person' => $validated['child_person'] ?? 0,
                'infant_person' => $validated['infant_person'] ?? 0,
                'number_of_pax' => $validated['number_of_pax'],
                'status' => $validated['status'],
            ];

            // Update the main booking record
            $booking->update($bookingData);

            // Delete existing related records
            $booking->hotelDetails()->delete();
            $booking->flightDetails()->delete();
            $booking->routeDetails()->delete();

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
                    'vehicle_id' => $validated['vehicle_id'][$index]
                ]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('bookings.index')
                ->with('success', 'Booking updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();

            // For debugging
            // return back()->withInput()->with('error', 'Failed to update booking: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to update booking. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        DB::beginTransaction();

        try {
            // don't allow deletion of confirmed/completed bookings
            if (in_array($booking->status, ['confirmed', 'completed'])) {
                return redirect()->route('bookings.index')
                    ->with('error', 'Cannot delete a booking with status: ' . $booking->status);
            }

            // Delete related records (if not using cascade delete in database)
            // These might be automatically deleted if foreign keys have ON DELETE CASCADE
            $booking->hotelDetails()->delete();
            $booking->flightDetails()->delete();
            $booking->routeDetails()->delete();

            // Delete the main booking
            $booking->delete();

            DB::commit();

            return redirect()->route('bookings.index')
                ->with('success', 'Booking deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();

            // Log the error for debugging
            // \Log::error('Failed to delete booking: ' . $e->getMessage());

            return redirect()->route('bookings.index')
                ->with('error', 'Failed to delete booking. Please try again.');
        }
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
