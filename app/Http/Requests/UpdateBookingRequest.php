<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Basic fields
            'title'                 => 'required|in:Mr.,Mrs.',
            'customer_name'         => 'required|string|max:191',
            'customer_email'        => 'nullable|email|max:191',
            'customer_contact_full' => 'required|string|max:20',
            'booking_by'            => 'required|exists:users,id',
            'adult_person'          => 'required|integer|min:1',
            'child_person'          => 'nullable|integer|min:0',
            'infant_person'         => 'nullable|integer|min:0',
            'number_of_pax'         => 'required|integer|min:1',
            'status'                => 'nullable|in:Pending,Confirmed,Completed,Cancelled',

            // Hotel details
            'city'                  => 'required|array|min:1',
            'city.*'                => 'required|string|max:191',
            'hotel_name'            => 'required|array|min:1',
            'hotel_name.*'          => 'required|string|max:255',
            'check_in_date'         => 'required|array|min:1',
            'check_in_date.*'       => 'nullable|date',
            'check_out_date'        => 'required|array|min:1',
            'check_out_date.*'      => 'nullable|date|after_or_equal:check_in_date.*',
            'duration'              => 'nullable|array',
            'duration.*'            => 'nullable|string',

            // Flight details
            'flight_code'           => 'nullable|array',
            'flight_code.*'         => 'nullable|string|max:50',
            'flight_from'           => 'nullable|array',
            'flight_from.*'         => 'nullable|string|max:20',
            'flight_to'             => 'nullable|array',
            'flight_to.*'           => 'nullable|string|max:20',
            'flight_date'           => 'nullable|array',
            'flight_date.*'         => 'nullable|date',
            'departure_time'        => 'nullable|array',
            'departure_time.*'      => 'nullable|date_format:H:i:s,H:i',
            'arrival_time'          => 'nullable|array',
            'arrival_time.*'        => 'nullable|date_format:H:i:s,H:i',

            // Route details
            'route_id'              => 'required|array|min:1',
            'route_id.*'            => 'required|integer|exists:routes,id',
            'pickup_date'           => 'required|array|min:1',
            'pickup_date.*'         => 'required|date',
            'pickup_time'           => 'required|array|min:1',
            'pickup_time.*'         => 'required|date_format:H:i',
            'vehicle_id'            => 'required|array|min:1',
            'vehicle_id.*'          => 'required|exists:vehicles,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            // Basic fields messages
            'title.required'                    => 'The title field is required.',
            'title.in'                          => 'The title must be either "Mr." or "Mrs.".',
            'customer_name.required'            => 'The customer name field is required.',
            'customer_email.email'              => 'The customer email must be a valid email address.',
            'customer_contact_full.required'    => 'The customer contact field is required.',
            'customer_contact_full.string'      => 'The customer contact must be a string.',
            'customer_contact_full.max'         => 'The customer contact must not exceed 20 characters.',
            'booking_by.required'               => 'The booking by field is required.',
            'booking_by.exists'                 => 'The selected booking by user does not exist.',
            'adult_person.required'             => 'The adult person field is required.',
            'adult_person.integer'              => 'The adult person must be an integer.',
            'adult_person.min'                  => 'The adult person must be at least 1.',
            'child_person.integer'              => 'The child person must be an integer.',
            'infant_person.integer'             => 'The infant person must be an integer.',
            'number_of_pax.required'            => 'The number of passengers field is required.',
            'number_of_pax.integer'             => 'The number of passengers must be an integer.',
            'number_of_pax.min'                 => 'The number of passengers must be at least 1.',
            'status.in'                         => 'The status must be one of: Pending, Confirmed, Completed, Cancelled.',

            // Hotel details messages
            'city.required'                     => 'The city field is required.',
            'city.array'                        => 'The city field must be an array.',
            'city.*.required'                   => 'Each city is required.',
            'city.*.string'                     => 'Each city must be a string.',
            'city.*.max'                        => 'Each city must not exceed 191 characters.',
            'hotel_name.required'               => 'The hotel name field is required.',
            'hotel_name.array'                  => 'The hotel name field must be an array.',
            'hotel_name.*.required'             => 'Each hotel name is required.',
            'hotel_name.*.string'               => 'Each hotel name must be a string.',
            'hotel_name.*.max'                  => 'Each hotel name must not exceed 191 characters.',
            'check_in_date.required'            => 'The check-in date field is required.',
            'check_in_date.array'               => 'The check-in date field must be an array.',
            'check_in_date.*.required'          => 'Each check-in date is required.',
            'check_in_date.*.date'              => 'Each check-in date must be a valid date.',
            'check_out_date.required'           => 'The check-out date field is required.',
            'check_out_date.array'              => 'The check-out date field must be an array.',
            'check_out_date.*.required'         => 'Each check-out date is required.',
            'check_out_date.*.date'             => 'Each check-out date must be a valid date.',
            'check_out_date.*.after_or_equal'   => 'Each check-out date must be after or equal to check-in date.',

            // Flight details messages
            'flight_code.array'                 => 'The flight code field must be an array.',
            'flight_code.*.required'            => 'Each flight code is required.',
            'flight_code.*.string'              => 'Each flight code must be a string.',
            'flight_code.*.max'                 => 'Each flight code must not exceed 50 characters.',
            'flight_date.array'                 => 'The flight date field must be an array.',
            'flight_date.*.required'            => 'Each flight date is required.',
            'flight_date.*.date'                => 'Each flight date must be a valid date.',
            'departure_time.array'              => 'The departure time field must be an array.',
            'departure_time.*.required'         => 'Each departure time is required.',
            'departure_time.*.date_format'      => 'Each departure time must be in the format HH:MM or HH:MM:SS.',
            'arrival_time.array'                => 'The arrival time field must be an array.',
            'arrival_time.*.required'           => 'Each arrival time is required.',
            'arrival_time.*.date_format'        => 'Each arrival time must be in the format HH:MM or HH:MM:SS.',
            'arrival_time.*.after'              => 'Each arrival time must be after the corresponding departure time.',

            // Route details messages
            'route_id.required'                 => 'The route ID field is required.',
            'route_id.array'                    => 'The route ID field must be an array.',
            'route_id.*.required'               => 'Each route ID is required.',
            'route_id.*.integer'                => 'Each route ID must be an integer.',
            'route_id.*.exists'                 => 'Each selected route ID does not exist.',
            'pickup_date.required'              => 'The pickup date field is required.',
            'pickup_date.array'                 => 'The pickup date field must be an array.',
            'pickup_date.*.required'            => 'Each pickup date is required.',
            'pickup_date.*.date'                => 'Each pickup date must be a valid date.',
            'pickup_time.required'              => 'The pickup time field is required.',
            'pickup_time.array'                 => 'The pickup time field must be an array.',
            'pickup_time.*.required'            => 'Each pickup time is required.',
            'pickup_time.*.date_format'         => 'Each pickup time must be in the format HH:MM.',
            'vehicle_id.required'               => 'The vehicle ID field is required.',
            'vehicle_id.array'                  => 'The vehicle ID field must be an array.',
            'vehicle_id.*.required'             => 'Each vehicle ID is required.',
            'vehicle_id.*.integer'              => 'Each vehicle ID must be an integer.',
            'vehicle_id.*.exists'               => 'Each selected vehicle ID does not exist.',
        ];
    }
}