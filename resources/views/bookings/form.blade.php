{{-- ================= Bookings Form ================= --}}
<div class="accordion" id="bookingsAccordion">

    {{-- ================= 1. Basic Information ================= --}}
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasicInfo">
                <strong>Basic Customer Information</strong>
            </button>
        </h2>

        <div id="collapseBasicInfo" class="accordion-collapse collapse show" data-bs-parent="#bookingsAccordion">
            <div class="accordion-body">
                <div class="row g-3">

                    {{-- ================= Customer Name ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('customer_name', 'Name', ['class' => 'form-label required-input']) !!}
                        <div class="d-flex gap-2">
                            {{-- Title Dropdown --}}
                            {!! Form::select('title', ['Mr.' => 'Mr.', 'Mrs.' => 'Mrs.'], old('title', isset($booking) && str_starts_with($booking->customer_name, 'Mrs.') ? 'Mrs.' : 'Mr.'), ['class' => 'form-select', 'style' => 'width: 90px;', 'required']) !!}
                            {{-- Customer Name --}}
                            {!! Form::text('customer_name', old('customer_name', isset($booking) ? trim(str_replace(['Mr.', 'Mrs.'], '', $booking->customer_name)) : ''), ['class' => 'form-control ' . $errors->first('customer_name', 'error'), 'placeholder' => 'Customer Name', 'maxlength' => '191', 'required']) !!}
                        </div>
                        {!! $errors->first('customer_name', '<label class="error">:message</label>') !!}
                    </div>                    
                    
                    {{-- ================= Customer Email ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('customer_email', 'Email', ['class' => 'form-label required-input']) !!}
                        {!! Form::email('customer_email', old('customer_email', $booking->customer_email ?? ''), ['class' => 'form-control ' . $errors->first('customer_email', 'error'),'placeholder' => 'Email Address','maxlength' => '64','required']) !!}
                        {!! $errors->first('customer_email', '<label class="error">:message</label>') !!}
                    </div>
                    
                    {{-- ================= Customer Contact ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('customer_contact', 'Contact Number', ['class' => 'form-label required-input']) !!}
                        {!! Form::text('customer_contact', old('customer_contact', $booking->customer_contact ?? ''), ['id' => 'customer_contact', 'class' => 'form-control ' . $errors->first('customer_contact', 'error'),'placeholder' => 'Mobile Number','maxlength' => '15','required']) !!}
                        {{-- Hidden full phone (with country code) --}}
                        {!! Form::hidden('customer_contact_full', old('customer_contact_full', $booking->customer_contact_full ?? ''), ['id' => 'customer_contact_full']) !!}
                        {!! $errors->first('customer_contact', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= Booking By ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('booking_by', 'Booking By', ['class' => 'form-label required-input']) !!}
                        {!! Form::select('booking_by',$users, old('booking_by', $booking->booking_by ?? ''),['class' => 'form-control ' . $errors->first('booking_by', 'error'),'placeholder' => 'Select User','required']) !!}
                        {!! $errors->first('booking_by', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= Total Amount ================= --}}
                    {{-- <div class="form-group col-md-4">
                        {!! Form::label('total_amount', 'Total Amount (SAR)', ['class' => 'form-label required-input']) !!}
                        {!! Form::number('total_amount', old('total_amount', $booking->total_amount ?? ''),['class' => 'form-control ' . $errors->first('total_amount', 'error'),'placeholder' => 'Total Amount','required']) !!}
                        {!! $errors->first('total_amount', '<label class="error">:message</label>') !!}
                    </div> --}}
                    
                    {{-- ================= Number of Pax ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('number_of_pax', 'Number of Pax', ['class' => 'form-label required-input']) !!}
                        {!! Form::number('number_of_pax', old('number_of_pax', $booking->number_of_pax ?? ''), ['class' => 'form-control ' . $errors->first('number_of_pax', 'error'), 'id' => 'number_of_pax', 'placeholder' => 'Enter total number of persons', 'min' => '1', 'max' => '50', 'required']) !!}
                        {!! $errors->first('number_of_pax', '<label class="error">:message</label>') !!}
                    </div>
                    
                    {{-- ================= Person Details ================= --}}
                    <div class="row g-3" id="person_details_section" style="{{ old('number_of_pax', $booking->number_of_pax ?? '') ? '' : 'display: none;' }}">
                        <h5>Persons Details</h5>
                        {{-- ================= Adult Persons ================= --}}
                        <div class="form-group col-md-4">
                            {!! Form::label('adult_person', 'Adult', ['class' => 'form-label required-input']) !!}
                            {!! Form::number('adult_person', old('adult_person', $booking->adult_person ?? 0), ['class' => 'form-control ' . $errors->first('adult_person', 'error'), 'id' => 'adult_person', 'placeholder' => 'Number of adults', 'min' => '0', 'required']) !!}
                            {!! $errors->first('adult_person', '<label class="error">:message</label>') !!}
                        </div>
                        {{-- ================= Child Persons ================= --}}
                        <div class="form-group col-md-4">
                            {!! Form::label('child_person', 'Child', ['class' => 'form-label required-input']) !!}
                            {!! Form::number('child_person', old('child_person', $booking->child_person ?? 0), ['class' => 'form-control ' . $errors->first('child_person', 'error'), 'id' => 'child_person', 'placeholder' => 'Number of children', 'min' => '0']) !!}
                            {!! $errors->first('child_person', '<label class="error">:message</label>') !!}
                        </div>                       
                        {{-- ================= Infant Persons ================= --}}
                        <div class="form-group col-md-4">
                            {!! Form::label('infant_person', 'Infant', ['class' => 'form-label']) !!}
                            {!! Form::number('infant_person', old('infant_person', $booking->infant_person ?? 0), ['class' => 'form-control ' . $errors->first('infant_person', 'error'), 'id' => 'infant_person', 'placeholder' => 'Number of infants', 'min' => '0']) !!}
                            {!! $errors->first('infant_person', '<label class="error">:message</label>') !!}
                        </div>
                        
                        {{-- Validation Message --}}
                        <div class="col-12">
                            <div class="alert alert-warning py-2" id="person_sum_alert" style="display: none;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Total persons (Adult + Child + Infant) must equal <span id="number_of_pax_display"></span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- ================= Accommodation Details ================= --}}
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Accomodation</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add_accommodation">
                            <i class="fas fa-plus me-1"></i> Add More
                        </button>
                    </div>
                    
                    {{-- Accommodation Container --}}
                    <div id="accommodation_container">
                        @php
                            $accommodations = $booking->accommodations ?? collect([]);
                            $hasAccommodations = $accommodations->isNotEmpty();
                            $accommodationData = $hasAccommodations ? $accommodations : [null];
                        @endphp
                        
                        @foreach($accommodationData as $index => $accommodation)
                        <div class="row g-3 accommodation-row" data-row-index="{{ $index }}">
                            {{-- Hidden accommodation ID for editing --}}
                            @if($accommodation && $accommodation->id)
                            {!! Form::hidden('accommodation_id[]', $accommodation->id) !!}
                            @endif
                            
                            {{-- ================= Hotel City ================= --}}
                            <div class="form-group col-md-2">
                                {!! Form::label('city[]', 'City', ['class' => 'form-label required-input']) !!}
                                {!! Form::text('city[]', old("city.$index", $accommodation->city ?? ''), ['class' => 'form-control accommodation-city', 'placeholder' => 'Makkah/Madinah','maxlength' => '191','required']) !!}
                            </div>
                            {{-- ================= Hotel Name ================= --}}
                            <div class="form-group col-md-3">
                                {!! Form::label('hotel_name[]', 'Hotel Name', ['class' => 'form-label required-input']) !!}
                                {!! Form::text('hotel_name[]', old("hotel_name.$index", $accommodation->hotel_name ?? ''), ['class' => 'form-control accommodation-hotel', 'placeholder' => 'Hotel Name','maxlength' => '191','required']) !!}
                            </div>
                            {{-- ================= Check-In Date ================= --}}
                            <div class="form-group col-md-2">
                                {!! Form::label('check_in_date[]', 'Check In Date', ['class' => 'form-label required-input']) !!}
                                {!! Form::date('check_in_date[]', old("check_in_date.$index", $accommodation->check_in_date ?? ''), ['class' => 'form-control accommodation-checkin', 'placeholder' => 'Select Date', 'required']) !!}
                            </div>
                            {{-- ================= Check-Out Date ================= --}}
                            <div class="form-group col-md-2">
                                {!! Form::label('check_out_date[]', 'Check Out Date', ['class' => 'form-label required-input']) !!}
                                {!! Form::date('check_out_date[]', old("check_out_date.$index", $accommodation->check_out_date ?? ''), ['class' => 'form-control accommodation-checkout', 'placeholder' => 'Select Date', 'required']) !!}
                            </div>
                            {{-- ================= Duration (Nights) ================= --}}
                            <div class="form-group col-md-2">
                                {!! Form::label('duration[]', 'Nights', ['class' => 'form-label']) !!}
                                {!! Form::text('duration[]', old("duration.$index", $accommodation->duration ?? ''), ['class' => 'form-control accommodation-duration', 'placeholder' => 'Nights','readonly' => true]) !!}
                            </div>
                            {{-- ================= Remove Button ================= --}}
                            <div class="form-group col-md-1 align-self-end">
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-outline-danger remove-accommodation">
                                    Remove
                                </button>
                                @else
                                <button type="button" class="btn btn-sm btn-outline-danger remove-accommodation" style="display: none;">
                                    Remove
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- ================= Flight Schedule ================= --}}  
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Flight Schedule</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add_flight">
                            <i class="fas fa-plus me-1"></i> Add More
                        </button>
                    </div>
                    
                    {{-- Flight Container --}}
                    <div id="flight_container">
                        @php
                            $flights = $booking->flights ?? collect([]);
                            $hasFlights = $flights->isNotEmpty();
                            $flightData = $hasFlights ? $flights : [null];
                        @endphp
                        
                        @foreach($flightData as $index => $flight)
                        <div class="row g-3 flight-row" data-row-index="{{ $index }}">
                            {{-- Hidden flight ID for editing --}}
                            @if($flight && $flight->id)
                            {!! Form::hidden('flight_id[]', $flight->id) !!}
                            @endif
                            
                            {{-- ================= Flight Code ================= --}} 
                            <div class="form-group col-md-3">
                                {!! Form::label('flight_code[]', 'Flight Code', ['class' => 'form-label required-input']) !!}
                                {!! Form::text('flight_code[]', old("flight_code.$index", $flight->flight_code ?? ''), ['class' => 'form-control flight-code', 'placeholder' => 'PK-301','maxlength' => '10','required']) !!}
                            </div>
                            {{-- ================= Flight From ================= --}} 
                            <div class="form-group col-md-1">
                                {!! Form::label('flight_from[]', 'From', ['class' => 'form-label required-input']) !!}
                                {!! Form::text('flight_from[]', old("flight_from.$index", $flight->flight_from ?? ''), ['class' => 'form-control flight-from', 'placeholder' => 'FCO','maxlength' => '10','required']) !!}
                            </div>
                            {{-- ================= Flight To ================= --}} 
                            <div class="form-group col-md-1">
                                {!! Form::label('flight_to[]', 'To', ['class' => 'form-label required-input']) !!}
                                {!! Form::text('flight_to[]', old("flight_to.$index", $flight->flight_to ?? ''), ['class' => 'form-control flight-to', 'placeholder' => 'JED','maxlength' => '10','required']) !!}
                            </div>
                            {{-- ================= Flight Date ================= --}}
                            <div class="form-group col-md-2">
                                {!! Form::label('flight_date[]', 'Flight Date', ['class' => 'form-label required-input']) !!}
                                {!! Form::date('flight_date[]', old("flight_date.$index", $flight->flight_date ?? ''), ['class' => 'form-control flight-date', 'placeholder' => 'Select Date', 'required']) !!}
                            </div>
                            {{-- ================= DEPARTURE Time ================= --}}
                            <div class="form-group col-md-2">
                                {!! Form::label('departure_time[]', 'Departure Time', ['class' => 'form-label required-input']) !!}
                                {!! Form::time('departure_time[]', old("departure_time.$index", $flight->departure_time ?? ''), ['class' => 'form-control flight-departure', 'placeholder' => 'Select Time', 'required']) !!}
                            </div>
                            {{-- ================= Arrival Time ================= --}}
                            <div class="form-group col-md-2">
                                {!! Form::label('arrival_time[]', 'Arrival Time', ['class' => 'form-label required-input']) !!}
                                {!! Form::time('arrival_time[]', old("arrival_time.$index", $flight->arrival_time ?? ''), ['class' => 'form-control flight-arrival', 'placeholder' => 'Select Time', 'required']) !!}
                            </div>
                            {{-- ================= Remove Button ================= --}}
                            <div class="form-group col-1 align-self-end">
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-outline-danger remove-flight">
                                    Remove
                                </button>
                                @else
                                <button type="button" class="btn btn-sm btn-outline-danger remove-flight" style="display: none;">
                                    Remove
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- ================= Routes Detail ================= --}}
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Routes Details</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add_route">
                            <i class="fas fa-plus me-1"></i> Add More
                        </button>
                    </div>
                    
                    {{-- Routes Container --}}
                    <div id="route_container">
                        @php
                            $routes = $booking->routes ?? collect([]);
                            $hasRoutes = $routes->isNotEmpty();
                            $routeData = $hasRoutes ? $routes : [null];
                        @endphp
                        
                        @foreach($routeData as $index => $route)
                        <div class="row g-3 route-row" data-row-index="{{ $index }}">
                            {{-- Hidden route ID for editing --}}
                            @if($route && $route->id)
                            {!! Form::hidden('route_id[]', $route->id) !!}
                            @endif
                            
                            {{-- ================= Pick & Drop ================= --}}
                            <div class="form-group col-md-3">
                                {!! Form::label('pick_up[]', 'Pick & Drop', ['class' => 'form-label required-input']) !!}
                                {!! Form::select('pick_up[]',['' => 'Select Route','Jeddah Airport To Makkah Hotel' => 'Jeddah Airport To Makkah Hotel','Makkah Hotel To Madinah Hotel' => 'Makkah Hotel To Madinah Hotel','Madinah Hotel To Jeddah Airport' => 'Madinah Hotel To Jedddah Airport','Madinah Hotel To Madinah Airport' => 'Madinah Hotel To Madinah Airport','Madinah Hotel To Makkah Hotel' => 'Madinah Hotel To Makkah Hotel', 'Makkah Hotel To Madinah Airport' => 'Makkah Hotel To Madinah Airport', 'Makkah Hotel to Jeddah Airport' => 'Makkah Hotel to Jeddah Airport','Makkah Hotel To Makkah Ziyarat' => 'Makkah Hotel To Makkah Ziyarat','Madinah Hotel To Madinah Ziyarat' => 'Madinah Hotel To Madinah Ziyarat'], old("pick_up.$index", $route->pick_up ?? ''), ['class' => 'form-control pick-up','maxlength' => '191','required']) !!}
                            </div>
                            {{-- ================= Date Field ================= --}}
                            <div class="form-group col-md-3 pickup-date-field" style="{{ old("pick_up.$index", $route->pick_up ?? '') ? '' : 'display: none;' }}">
                                {!! Form::label('pickup_date[]', 'Pick-up Date', ['class' => 'form-label required-input']) !!}
                                {!! Form::date('pickup_date[]', old("pickup_date.$index", $route->pickup_date ?? ''), ['class' => 'form-control pickup-date', 'placeholder' => 'Select Date', 'required']) !!}
                            </div>
                            {{-- ================= Time Field ================= --}}
                            <div class="form-group col-md-2 pickup-time-field" style="{{ old("pick_up.$index", $route->pick_up ?? '') ? '' : 'display: none;' }}">
                                {!! Form::label('pickup_time[]', 'Pick-up Time', ['class' => 'form-label required-input']) !!}
                                {!! Form::time('pickup_time[]', old("pickup_time.$index", $route->pickup_time ?? ''), ['class' => 'form-control pickup-time', 'placeholder' => 'Select Time', 'required']) !!}
                            </div>
                            {{-- ================= Vehicle Selection ================= --}}
                            <div class="form-group col-md-3 vehicle-id-field">
                                {!! Form::label('vehicle_id[]', 'Select Vehicle', ['for' => 'vehicle_id', 'class' => 'form-label required-input']) !!}
                                {!! Form::select('vehicle_id[]', ['' => 'Select Vehicle'] + ($vehicles->toArray() ?? []), old("vehicle_id.$index", $route->vehicle_id ?? ''), ['class' => 'form-control ' . ($errors->has('vehicle_id') ? 'error' : ''), 'id' => 'vehicle_id','required']) !!}
                            </div>
                            {{-- ================= Remove Button ================= --}}
                            <div class="form-group col-1 align-self-end">
                                @if($index > 0)
                                <button type="button" class="btn btn-sm btn-outline-danger remove-route">
                                    Remove
                                </button>
                                @else
                                <button type="button" class="btn btn-sm btn-outline-danger remove-route" style="display: none;">
                                    Remove
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>

<script>
    $(document).ready(function () {
        // Initialize variables based on existing rows
        let accommodationCounter = {{ count($accommodationData ?? []) }};
        let flightCounter = {{ count($flightData ?? []) }};
        let routeCounter = {{ count($routeData ?? []) }};
        
        // Initialize form validation
        $('#formValidation').validate();
        $('.cnic-mask').mask('00000-0000000-0');
        // $('#academic_year_start , #academic_year_end').monthpicker({dateFormat: "MM yy"});

        // Initialize phone input
        var input = $('#customer_contact')[0];
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            preferredCountries: ["sa", "pk", "ae", "us", "gb"],
            utilsScript: "{{ asset('assets/intl-tel-input/js/utils.js') }}",
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "sa";
                    callback(countryCode);
                });
            }
        });

        // Set the phone number if editing
        @if(isset($booking) && $booking->customer_contact)
            iti.setNumber("{{ $booking->customer_contact }}");
        @endif

        // Function to update full number
        function updateFullNumber() {
            var fullNumber = iti.getNumber();
            $('#customer_contact_full').val(fullNumber);
        }

        // Trigger on input or country change
        $(input).on('input change', updateFullNumber);
        input.addEventListener('countrychange', updateFullNumber);

        // Initialize on load
        updateFullNumber();

        // Set minimum date to today for all date inputs
        var today = new Date().toISOString().split('T')[0];
        $('input[type="date"]').each(function() {
            $(this).attr('min', today);
        });

        // Show date and time fields when pick_up field has data
        $(document).on('change', '.pick-up', function() {
            var $row = $(this).closest('.route-row');
            var pickUpValue = $(this).val().trim();
            
            var $dateField = $row.find('.pickup-date-field');
            var $timeField = $row.find('.pickup-time-field');
            var $vehicleField = $row.find('.vehicle-id-field');
            
            if (pickUpValue.length > 0) {
                $dateField.slideDown(300);
                $timeField.slideDown(300);
                $vehicleField.removeClass('col-md-3').addClass('col-md-3');
                $row.find('.pickup-date').prop('required', true);
                $row.find('.pickup-time').prop('required', true);
                
                // Set minimum date to today
                $row.find('.pickup-date').attr('min', today);
                
                setTimeout(function() {
                    $row.find('.pickup-date').focus();
                }, 350);
            } else {
                $dateField.slideUp(300);
                $timeField.slideUp(300);
                $vehicleField.removeClass('col-md-3').addClass('col-md-3');
                $row.find('.pickup-date').prop('required', false).val('');
                $row.find('.pickup-time').prop('required', false).val('');
            }
        });

        // Initialize pick-up fields on page load
        $('.pick-up').each(function() {
            if ($(this).val().trim()) {
                $(this).trigger('change');
            }
        });

        // Add Accommodation Row
        $('#add_accommodation').on('click', function() {
            const newRow = $('.accommodation-row:first').clone();
            const rowIndex = accommodationCounter++;
            
            // Update data attribute
            newRow.attr('data-row-index', rowIndex);
            
            // Clear input values
            newRow.find('input[type="text"], input[type="date"]').val('');
            newRow.find('input[name="accommodation_id[]"]').val(''); // Clear any hidden ID
            
            // Update names for array indexing
            newRow.find('input[name="accommodation_id[]"]').attr('name', 'accommodation_id[' + rowIndex + ']');
            newRow.find('input[name="city[]"]').attr('name', 'city[' + rowIndex + ']');
            newRow.find('input[name="hotel_name[]"]').attr('name', 'hotel_name[' + rowIndex + ']');
            newRow.find('input[name="check_in_date[]"]').attr('name', 'check_in_date[' + rowIndex + ']');
            newRow.find('input[name="check_out_date[]"]').attr('name', 'check_out_date[' + rowIndex + ']');
            newRow.find('input[name="duration[]"]').attr('name', 'duration[' + rowIndex + ']');
            
            // Show remove button for new row
            newRow.find('.remove-accommodation').show();
            
            // Add event listeners for new row
            newRow.find('.accommodation-checkin, .accommodation-checkout').on('change', calculateRowDuration);
            
            // Append to container
            $('#accommodation_container').append(newRow);
            
            // Initialize validation for new row
            initializeValidationForNewRow(newRow);
            
            // Set minimum date
            newRow.find('input[type="date"]').attr('min', today);
        });

        // Add Flight Row
        $('#add_flight').on('click', function() {
            const newRow = $('.flight-row:first').clone();
            const rowIndex = flightCounter++;
            
            // Update data attribute
            newRow.attr('data-row-index', rowIndex);
            
            // Clear input values
            newRow.find('input[type="text"], input[type="date"], input[type="time"]').val('');
            newRow.find('input[name="flight_id[]"]').val(''); // Clear any hidden ID
            
            // Update names for array indexing
            newRow.find('input[name="flight_id[]"]').attr('name', 'flight_id[' + rowIndex + ']');
            newRow.find('input[name="flight_code[]"]').attr('name', 'flight_code[' + rowIndex + ']');
            newRow.find('input[name="flight_from[]"]').attr('name', 'flight_from[' + rowIndex + ']');
            newRow.find('input[name="flight_to[]"]').attr('name', 'flight_to[' + rowIndex + ']');
            newRow.find('input[name="flight_date[]"]').attr('name', 'flight_date[' + rowIndex + ']');
            newRow.find('input[name="departure_time[]"]').attr('name', 'departure_time[' + rowIndex + ']');
            newRow.find('input[name="arrival_time[]"]').attr('name', 'arrival_time[' + rowIndex + ']');
            
            // Show remove button for new row
            newRow.find('.remove-flight').show();
            
            // Append to container
            $('#flight_container').append(newRow);
            
            // Initialize validation for new row
            initializeValidationForNewRow(newRow);
            
            // Set minimum date
            newRow.find('input[type="date"]').attr('min', today);
        });

        // Add Route Row
        $('#add_route').on('click', function() {
            const newRow = $('.route-row:first').clone();
            const rowIndex = routeCounter++;
            
            // Update data attribute
            newRow.attr('data-row-index', rowIndex);
            
            // Clear input values
            newRow.find('select').val('');
            newRow.find('input').val('');
            newRow.find('input[name="route_id[]"]').val(''); // Clear any hidden ID
            
            // Update names for array indexing
            newRow.find('input[name="route_id[]"]').attr('name', 'route_id[' + rowIndex + ']');
            newRow.find('select[name="pick_up[]"]').attr('name', 'pick_up[' + rowIndex + ']');
            newRow.find('input[name="pickup_date[]"]').attr('name', 'pickup_date[' + rowIndex + ']');
            newRow.find('input[name="pickup_time[]"]').attr('name', 'pickup_time[' + rowIndex + ']');
            newRow.find('select[name="vehicle_id[]"]').attr('name', 'vehicle_id[' + rowIndex + ']');
            
            // Hide date/time fields for new rows initially
            newRow.find('.pickup-date-field').hide();
            newRow.find('.pickup-time-field').hide();

            // Show remove button for new row
            newRow.find('.remove-route').show();
            
            // Append to container
            $('#route_container').append(newRow);
            
            // Initialize validation for new row
            initializeValidationForNewRow(newRow);
            
            // Set minimum date
            newRow.find('input[type="date"]').attr('min', today);
        });

        // Remove Accommodation Row
        $(document).on('click', '.remove-accommodation', function() {
            const row = $(this).closest('.accommodation-row');
            const rowIndex = row.data('row-index');
            
            // Don't remove first row
            if (rowIndex > 0) {
                row.remove();
                updateRowIndexes('#accommodation_container', '.accommodation-row', 'accommodation_id');
                accommodationCounter--;
            }
        });

        // Remove Flight Row
        $(document).on('click', '.remove-flight', function() {
            const row = $(this).closest('.flight-row');
            const rowIndex = row.data('row-index');
            
            // Don't remove first row
            if (rowIndex > 0) {
                row.remove();
                updateRowIndexes('#flight_container', '.flight-row', 'flight_id');
                flightCounter--;
            }
        });

        // Remove Route Row
        $(document).on('click', '.remove-route', function() {
            const row = $(this).closest('.route-row');
            const rowIndex = row.data('row-index');
            
            // Don't remove first row
            if (rowIndex > 0) {
                row.remove();
                updateRowIndexes('#route_container', '.route-row', 'route_id');
                routeCounter--;
            }
        });

        // Function to update row indexes after removal
        function updateRowIndexes(containerSelector, rowSelector, idFieldName = '') {
            $(containerSelector + ' ' + rowSelector).each(function(index) {
                $(this).attr('data-row-index', index);
                
                // Update array indexes for form submission
                if (containerSelector === '#accommodation_container') {
                    $(this).find('input[name^="accommodation_id["]').attr('name', 'accommodation_id[' + index + ']');
                    $(this).find('input[name^="city["]').attr('name', 'city[' + index + ']');
                    $(this).find('input[name^="hotel_name["]').attr('name', 'hotel_name[' + index + ']');
                    $(this).find('input[name^="check_in_date["]').attr('name', 'check_in_date[' + index + ']');
                    $(this).find('input[name^="check_out_date["]').attr('name', 'check_out_date[' + index + ']');
                    $(this).find('input[name^="duration["]').attr('name', 'duration[' + index + ']');
                } else if (containerSelector === '#flight_container') {
                    $(this).find('input[name^="flight_id["]').attr('name', 'flight_id[' + index + ']');
                    $(this).find('input[name^="flight_code["]').attr('name', 'flight_code[' + index + ']');
                    $(this).find('input[name^="flight_from["]').attr('name', 'flight_from[' + index + ']');
                    $(this).find('input[name^="flight_to["]').attr('name', 'flight_to[' + index + ']');
                    $(this).find('input[name^="flight_date["]').attr('name', 'flight_date[' + index + ']');
                    $(this).find('input[name^="departure_time["]').attr('name', 'departure_time[' + index + ']');
                    $(this).find('input[name^="arrival_time["]').attr('name', 'arrival_time[' + index + ']');
                } else if (containerSelector === '#route_container') {
                    $(this).find('input[name^="route_id["]').attr('name', 'route_id[' + index + ']');
                    $(this).find('select[name^="pick_up["]').attr('name', 'pick_up[' + index + ']');
                    $(this).find('input[name^="pickup_date["]').attr('name', 'pickup_date[' + index + ']');
                    $(this).find('input[name^="pickup_time["]').attr('name', 'pickup_time[' + index + ']');
                    $(this).find('select[name^="vehicle_id["]').attr('name', 'vehicle_id[' + index + ']');
                }
            });
        }

        // Function to calculate duration for accommodation row
        function calculateRowDuration() {
            const row = $(this).closest('.accommodation-row');
            const checkIn = row.find('.accommodation-checkin').val();
            const checkOut = row.find('.accommodation-checkout').val();
            const durationField = row.find('.accommodation-duration');
            
            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                
                if (checkOutDate > checkInDate) {
                    const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    durationField.val(nights + ' night' + (nights !== 1 ? 's' : ''));
                    return;
                }
            }
            
            durationField.val('');
        }

        // Initialize duration calculation for all existing rows
        $(document).on('change', '.accommodation-checkin, .accommodation-checkout', calculateRowDuration);
        
        // Calculate duration for existing rows on page load
        $('.accommodation-row').each(function() {
            const checkIn = $(this).find('.accommodation-checkin').val();
            const checkOut = $(this).find('.accommodation-checkout').val();
            const durationField = $(this).find('.accommodation-duration');
            
            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                
                if (checkOutDate > checkInDate) {
                    const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    durationField.val(nights + ' night' + (nights !== 1 ? 's' : ''));
                }
            }
        });

        // Handle total persons change
        $('#number_of_pax').on('change keyup', function() {
            var totalPersons = $(this).val();
            
            if (totalPersons && totalPersons > 0) {
                $('#person_details_section').slideDown();
                $('#number_of_pax_display').text(totalPersons);
                
                // Only auto-set if all person fields are empty
                if (!$('#adult_person').val() && !$('#child_person').val() && !$('#infant_person').val()) {
                    $('#adult_person').val(totalPersons);
                    $('#child_person').val(0);
                    $('#infant_person').val(0);
                }
                
                validatePersonSum();
            } else {
                $('#person_details_section').slideUp();
            }
        });

        // Validate person sum whenever any of the person fields change
        $('#adult_person, #child_person, #infant_person').on('change keyup', function() {
            validatePersonSum();
        });

        // Function to validate if sum equals total persons
        function validatePersonSum() {
            var totalPersons = parseInt($('#number_of_pax').val()) || 0;
            var adultPersons = parseInt($('#adult_person').val()) || 0;
            var childPersons = parseInt($('#child_person').val()) || 0;
            var infantPersons = parseInt($('#infant_person').val()) || 0;
            var sum = adultPersons + childPersons + infantPersons;
            
            if (sum === totalPersons) {
                $('#person_sum_alert').hide();
                $('#adult_person, #child_person, #infant_person').removeClass('error');
            } else {
                $('#person_sum_alert').show();
                $('#adult_person, #child_person, #infant_person').addClass('error');
            }
        }

        // Add custom validation rule for form submission
        $.validator.addMethod("personSumCheck", function(value, element) {
            var totalPersons = parseInt($('#number_of_pax').val()) || 0;
            var adultPersons = parseInt($('#adult_person').val()) || 0;
            var childPersons = parseInt($('#child_person').val()) || 0;
            var infantPersons = parseInt($('#infant_person').val()) || 0;
            var sum = adultPersons + childPersons + infantPersons;
            
            return sum === totalPersons;
        }, "Total persons must equal Adult + Child + Infant");

        // Function to initialize validation for new rows
        function initializeValidationForNewRow(row) {
            const validator = $('#formValidation').validate();
            
            // Accommodation fields validation
            row.find('.accommodation-city').rules('add', {
                required: true,
                messages: {
                    required: "City is required"
                }
            });
            
            row.find('.accommodation-hotel').rules('add', {
                required: true,
                messages: {
                    required: "Hotel name is required"
                }
            });
            
            row.find('.accommodation-checkin').rules('add', {
                required: true,
                messages: {
                    required: "Check-in date is required"
                }
            });
            
            row.find('.accommodation-checkout').rules('add', {
                required: true,
                messages: {
                    required: "Check-out date is required"
                }
            });

            // Flight fields validation
            row.find('.flight-code').rules('add', {
                required: true,
                messages: {
                    required: "Flight code is required"
                }
            });
            
            row.find('.flight-from').rules('add', {
                required: true,
                messages: {
                    required: "Flight from is required"
                }
            });
            
            row.find('.flight-to').rules('add', {
                required: true,
                messages: {
                    required: "Flight to is required"
                }
            });
            
            row.find('.flight-date').rules('add', {
                required: true,
                messages: {
                    required: "Flight date is required"
                }
            });
            
            row.find('.flight-departure').rules('add', {
                required: true,
                messages: {
                    required: "Departure time is required"
                }
            });
            
            row.find('.flight-arrival').rules('add', {
                required: true,
                messages: {
                    required: "Arrival time is required"
                }
            });

            // Route fields validation
            row.find('.pick-up').rules('add', {
                required: true,
                messages: {
                    required: "Pick-up location is required"
                }
            });
            
            row.find('.pickup-date').rules('add', {
                required: true,
                messages: {
                    required: "Pickup date is required"
                }
            });
            
            row.find('.pickup-time').rules('add', {
                required: true,
                messages: {
                    required: "Pickup time is required"
                }
            });
            
            row.find('select[name^="vehicle_id"]').rules('add', {
                required: true,
                messages: {
                    required: "Vehicle selection is required"
                }
            });
        }

        // Initialize validation for existing rows on page load
        $('.accommodation-row, .flight-row, .route-row').each(function() {
            initializeValidationForNewRow($(this));
        });

        // Update form validation rules
        $('#formValidation').validate({
            rules: {
                adult_person: {
                    required: {
                        depends: function() {
                            return $('#number_of_pax').val() && $('#number_of_pax').val() > 0;
                        }
                    },
                    personSumCheck: true
                },
                child_person: {
                    required: {
                        depends: function() {
                            return $('#number_of_pax').val() && $('#number_of_pax').val() > 0;
                        }
                    },
                    personSumCheck: true
                }
            },
            errorPlacement: function(error, element) {
                // Handle error placement for dynamic rows
                if (element.hasClass('accommodation-city') || 
                    element.hasClass('accommodation-hotel') ||
                    element.hasClass('accommodation-checkin') ||
                    element.hasClass('accommodation-checkout') ||
                    element.hasClass('flight-code') ||
                    element.hasClass('flight-from') ||
                    element.hasClass('flight-to') ||
                    element.hasClass('flight-date') ||
                    element.hasClass('flight-departure') ||
                    element.hasClass('flight-arrival') ||
                    element.hasClass('pick-up') ||
                    element.hasClass('pickup-date') ||
                    element.hasClass('pickup-time') ||   
                    element.attr('name') === 'vehicle_id[]') {
                    
                    error.insertAfter(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Trigger number_of_pax change on page load if it has value
        @if(isset($booking) && $booking->number_of_pax)
            $('#number_of_pax').trigger('change');
        @endif
    });
</script>
@endpush