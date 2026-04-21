<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\BookingsHotelDetail;
use App\Models\BookingsRouteDetail;
use App\Models\BookingsFlightDetail;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $routes = BookingsRouteDetail::with([
                'booking:id,uuid,voucher_number,customer_name,customer_contact,status',
                'vehicle:id,name',
                'route:id,from_location,to_location'
            ]);

            return DataTables::of($routes)

                ->addColumn('route_id', function($r) {
                    if ($r->route && $r->route->from_location && $r->route->to_location) {
                        return $r->route->from_location . ' To ' . $r->route->to_location;
                    }
                    return $r->route_id;
                })
                ->addColumn('pickup_date', fn($r) => $r->pickup_date ? $r->pickup_date->format('d-m-Y') : '')
                ->addColumn('pickup_time', fn($r) => $r->pickup_time ? $r->pickup_time->format('h:i A') : '')
                
                ->filterColumn('pickup_date', function($query, $keyword) {
                    $query->where(function($q) use ($keyword) {
                        $q->whereRaw("DATE_FORMAT(pickup_date, '%d-%m-%Y') like ?", ["%{$keyword}%"])
                          ->orWhereRaw("DATE_FORMAT(pickup_date, '%Y-%m-%d') like ?", ["%{$keyword}%"]);
                    });
                })

                ->addColumn('status', function ($r) {
                    return $this->formatStatusBadge($r->booking->status);
                })
                ->addColumn('route_status', function ($r) {
                    return $this->formatStatusBadge($r->status);
                })
                
                ->addColumn('action', function ($r) {
                    $booking = $r->booking;

                    $actions = '<div class="overlay-edit d-flex">';

                    if (auth()->user()->can('Update Booking')) {
                        $actions .= '<a href="' . route('bookings.edit', $booking->uuid) . '" class="btn btn-icon btn-secondary me-1">
                        <i class="feather icon-edit-2"></i></a>';
                    }

                    if (auth()->user()->can('View Booking')) {
                        $actions .= '<a href="' . route('bookings.show', $booking->uuid) . '" class="btn btn-icon btn-info me-1"><i class="feather icon-eye"></i></a>';
                    }

                    if (auth()->user()->can('Update Booking Status')) {
                        $actions .= '<button type="button" class="btn btn-icon btn-warning me-1 btn-change-status" data-route-uuid="' . $r->uuid . '" data-current-status="' . $r->status . '" title="Change Route Status">
                        <i class="feather icon-refresh-ccw"></i></button>';
                    }

                    if (auth()->user()->can('View Booking Voucher')) {
                        $actions .= '<a href="' . route('bookings.bookingvoucher', $booking->uuid) . '" class="btn btn-icon btn-info me-1">
                        <i class="feather icon-file-text"></i></a>';
                    }

                    if (auth()->user()->can('Delete Booking')) {
                        $actions .= '<a href="' . route('bookings.destroy', $booking->uuid) . '" class="btn btn-icon btn-danger btn-delete">
                        <i class="feather icon-trash-2"></i></a>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                
                ->rawColumns(['status', 'route_status', 'action'])
                ->make(true);
        }

        return view('bookings.index');
    }

    /**
     * Format status badge for display
     *
     * @param string $status
     * @return string
     */
    private function formatStatusBadge($status)
    {
        if (empty($status)) {
            return '<span class="badge bg-secondary">N/A</span>';
        }
        $status = strtolower($status);
        $badgeClass = '';
        $statusText = ucfirst($status);

        switch ($status) {
            case 'pending':
                $badgeClass = 'bg-warning';
                break;
            case 'confirmed':
                $badgeClass = 'bg-success';
                break;
            case 'completed':
                $badgeClass = 'bg-info';
                break;
            case 'cancelled':
                $badgeClass = 'bg-danger';
                break;
            default:
                $badgeClass = 'bg-secondary';
        }

        return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $routeOptions = Route::active()->get()
            ->mapWithKeys(function ($route) {
                $displayName = $route->from_location . ' To ' . $route->to_location;
                return [$route->id => $displayName];
            });
        $vehicles = Vehicle::active()->pluck('name', 'id');

        return view('bookings.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        // Calculate number of pax automatically if not provided
        if (empty($validated['number_of_pax'])) {
            $validated['number_of_pax'] = ($validated['adult_person'] ?? 0) +
                                          ($validated['child_person'] ?? 0) +
                                          ($validated['infant_person'] ?? 0);
        }

        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = 'Pending';
        }
        $fullContactNumber = $request->input('customer_contact_full');
            if (empty($fullContactNumber)) {
                return back()->withErrors(['customer_contact' => 'Please enter a valid contact number.'])->withInput();
            }

        // Extract main booking data (non-array fields)
        $bookingData = [
            'customer_name' => trim($validated['title'] . ' ' . $validated['customer_name']),
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_contact' => $fullContactNumber,
            'booking_by' => $validated['booking_by'] ?? auth()->id(),
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
        foreach ($validated['route_id'] as $index => $pickUp) {
            BookingsRouteDetail::create([
                'booking_id' => $booking->id,
                'route_id' => $pickUp,
                'pickup_date' => $validated['pickup_date'][$index],
                'pickup_time' => $validated['pickup_time'][$index],
                'vehicle_id' => $validated['vehicle_id'][$index]
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
        // For debugging, show the actual error
        // return back()->withInput()->with('error', 'Failed to create booking: ' . $e->getMessage());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $booking->load('hotelDetails', 'flightDetails', 'routeDetails');
        $users = User::pluck('name', 'id');
        $routeOptions = Route::active()->get()
            ->mapWithKeys(function ($route) {
                $displayName = $route->from_location . ' To ' . $route->to_location;
                return [$route->id => $displayName];
            });
        $vehicles = Vehicle::active()->pluck('name', 'id');

        return view('bookings.view', get_defined_vars());
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $booking->load('hotelDetails', 'flightDetails', 'routeDetails');
        $users = User::pluck('name', 'id');
        $routeOptions = Route::active()->get()
            ->mapWithKeys(function ($route) {
                $displayName = $route->from_location . ' To ' . $route->to_location;
                return [$route->id => $displayName];
            });
        $vehicles = Vehicle::active()->pluck('name', 'id');

        return view('bookings.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        DB::beginTransaction();

        $validated = $request->validated();

        // Calculate number of pax automatically if not provided
        if (empty($validated['number_of_pax'])) {
            $validated['number_of_pax'] = ($validated['adult_person'] ?? 0) +
                                          ($validated['child_person'] ?? 0) +
                                          ($validated['infant_person'] ?? 0);
        }

        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = $booking->status; // Keep existing status
        }

        $fullContactNumber = $request->input('customer_contact_full');

        if (empty($fullContactNumber)) {
            DB::rollback();
            return back()->withErrors(['customer_contact' => 'Please enter a valid contact number.'])->withInput();
        }

        // Extract main booking data
        $bookingData = [
            'customer_name' => trim($validated['title'] . ' ' . $validated['customer_name']),
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
        foreach ($validated['route_id'] as $index => $pickUp) {
            BookingsRouteDetail::create([
                'booking_id' => $booking->id,
                'route_id' => $pickUp,
                'pickup_date' => $validated['pickup_date'][$index],
                'pickup_time' => $validated['pickup_time'][$index],
                'vehicle_id' => $validated['vehicle_id'][$index]
            ]);
        }

        DB::commit();

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
        // For debugging
        // return back()->withInput()->with('error', 'Failed to update booking: ' . $e->getMessage());
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
            if (in_array($booking->status, ['Confirmed', 'Completed'])) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete a booking that has status ' . $booking->status
                    ], 422);
                }
            }

            // Delete related records (if not using cascade delete in database)
            $booking->hotelDetails()->delete();
            $booking->flightDetails()->delete();
            $booking->routeDetails()->delete();

            // Delete the main booking
            $booking->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking deleted successfully!'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete booking. Please try again.'
                ], 500);
            }
        }
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $uuid)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled'
        ]);

        try {
            $booking = Booking::where('uuid', $uuid)->firstOrFail();

            // Check permission
            if (!auth()->user()->can('Update Booking Status')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to update booking status.'
                ], 403);
            }

            $oldStatus = $booking->status;
            $booking->status = $request->status;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully!',
                'new_status' => $booking->status,
                'status_badge' => $this->formatStatusBadge($booking->status)
            ]);
            // return $this->sendResponse(true, __('messages.booking_update'));

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the status of a specific route detail record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRouteStatus(Request $request, $uuid)
    {
        $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled'
        ]);

        try {
            $routeDetail = BookingsRouteDetail::where('uuid', $uuid)->firstOrFail();

            if (!auth()->user()->can('Update Route Status')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to update route status.'
                ], 403);
            }

            $routeDetail->status = $request->status;
            $routeDetail->save();

            return response()->json([
                'success' => true,
                'message' => 'Route status updated successfully!',
                'new_status' => $routeDetail->status,
                'status_badge' => $this->formatStatusBadge($routeDetail->status)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
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
                'hotelDetails',
                'flightDetails',
                'routeDetails.vehicle',
                'bookedBy',
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
}
