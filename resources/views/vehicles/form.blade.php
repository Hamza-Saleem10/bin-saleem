{{-- ================= Vehicles Form ================= --}}
<div class="accordion" id="vehiclesAccordion">

    {{-- ================= 1. Basic Information ================= --}}
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasicInfo">
                <strong>Basic Vehicle Information</strong>
            </button>
        </h2>

        <div id="collapseBasicInfo" class="accordion-collapse collapse show" data-bs-parent="#vehiclesAccordion">
            <div class="accordion-body">
                <div class="row g-3">

                    {{-- =================  Name ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('name', 'Name', ['class' => 'form-label required-input']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control ' . $errors->first('name', 'error'),'placeholder' => 'Vehicle Name','maxlength' => '191','required']) !!}
                        {!! $errors->first('name', '<label class="error">:message</label>') !!}
                    </div>
                    {{-- ================= Vehicle Seats ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('seats', 'Seats', ['class' => 'form-label required-input']) !!}
                        {!! Form::number('seats', null, ['class' => 'form-control ' . $errors->first('seats', 'error'),'placeholder' => 'Total Available Seats','maxlength' => '5','required']) !!}
                        {!! $errors->first('seats', '<label class="error">:message</label>') !!}
                    </div>
                    {{-- ================= Bags Capacity ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('bags_capacity', 'Bags Capacity', ['class' => 'form-label required-input']) !!}
                        {!! Form::number('bags_capacity', null, ['class' => 'form-control ' . $errors->first('bags_capacity', 'error'),'placeholder' => 'Available Bags Capacity','maxlength' => '5','required']) !!}
                        {!! $errors->first('bags_capacity', '<label class="error">:message</label>') !!}
                    </div>
                    {{-- =================  Vehicle Features ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('features', 'Features', ['class' => 'form-label required-input']) !!}
                        {!! Form::text('features', null, ['class' => 'form-control ' . $errors->first('features', 'error'),'placeholder' => 'Vehicle Features','maxlength' => '191','required']) !!}
                        {!! $errors->first('features', '<label class="error">:message</label>') !!}
                    </div>
                    {{-- =================  Vehicle Image ================= --}}
                    <div class="form-group col-md-4">
                        {!! Form::label('vehicle_image', 'Vehicle Image', ['class' => 'form-label required-input']) !!}
                        {!! Form::file('vehicle_image', ['class' => 'form-control ' . $errors->first('vehicle_image', 'error'),'accept' => 'image/*','required']) !!}
                        {!! $errors->first('vehicle_image', '<label class="error">:message</label>') !!}
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