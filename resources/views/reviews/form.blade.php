{{-- ================= Reviews Form ================= --}}
<div class="accordion" id="reviewsAccordion">

    {{-- ================= 1. Basic Information ================= --}}
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasicInfo">
                <strong>Basic Reviews Information</strong>
            </button>
        </h2>

        <div id="collapseBasicInfo" class="accordion-collapse collapse show" data-bs-parent="#reviewsAccordion">
            <div class="accordion-body">
                <div class="row g-3">
                    {{-- ================= Author Name ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('author', 'Author Name', ['class' => 'form-label required-input']) !!}
                        {!! Form::text('author', null, ['class' => 'form-control ' . $errors->first('author', 'error'), 'placeholder' => '', 'required']) !!}
                        {!! $errors->first('author', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= Location ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('location', 'Location', ['class' => 'form-label required-input']) !!}
                        {!! Form::text('location', null, ['class' => 'form-control ' . $errors->first('location', 'error'), 'placeholder' => 'e.g., Jeddah, Saudi Arabia', 'required']) !!}
                        {!! $errors->first('location', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= Rating ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('rating', 'Rating', ['class' => 'form-label required-input']) !!}
                        {!! Form::select('rating', [
                            '' => '-- Select Rating --',
                            5 => '5 Stars - Excellent',
                            4 => '4 Stars - Very Good',
                            3 => '3 Stars - Good',
                            2 => '2 Stars - Fair',
                            1 => '1 Star - Poor',
                        ], null, ['class' => 'form-control ' . $errors->first('rating', 'error'), 'required']) !!}
                        {!! $errors->first('rating', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= Booking Reference ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('booking_reference', 'Booking Reference (Optional)', ['class' => 'form-label']) !!}
                        {!! Form::text('booking_reference', null, ['class' => 'form-control ' . $errors->first('booking_reference', 'error'), 'placeholder' => 'e.g. BSL-2025-0481']) !!}
                        {!! $errors->first('booking_reference', '<label class="error">:message</label>') !!}
                    </div>
                    
                    {{-- ================= Booking Route ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('route_detail', 'Route Details', ['class' => 'form-label']) !!}
                        {!! Form::text('route_detail', null, ['class' => 'form-control ' . $errors->first('route_detail', 'error'), 'placeholder' => 'e.g. Jeddah to Makkah']) !!}
                        {!! $errors->first('route_detail', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= Travelling Date ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('travel_date', 'Traveling Date', ['class' => 'form-label']) !!}
                        {!! Form::date('travel_date', null, ['class' => 'form-control ' . $errors->first('travel_date', 'error'), 'placeholder' => 'e.g. 12 Apr 2025']) !!}
                        {!! $errors->first('travel_date', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= Comment ================= --}}
                    <div class="form-group col-md-12">
                        {!! Form::label('comment', 'Comment', ['class' => 'form-label required-input']) !!}
                        {!! Form::textarea('comment', null, ['class' => 'form-control ' . $errors->first('comment', 'error'), 'rows' => '5', 'required']) !!}
                        {!! $errors->first('comment', '<label class="error">:message</label>') !!}
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
    // Initialize form validation
    $('#formValidation').validate();
    $('.cnic-mask').mask('00000-0000000-0');
});
</script>
@endpush