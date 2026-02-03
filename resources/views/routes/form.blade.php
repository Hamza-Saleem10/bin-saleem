{{-- ================= Routes Form ================= --}}
<div class="accordion" id="routesAccordion">

    {{-- ================= 1. Basic Route Information ================= --}}
    <div class="accordion-item">

        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasicInfo">
                <strong>Basic Route Information</strong>
            </button>
        </h2>

        <div id="collapseBasicInfo" class="accordion-collapse collapse show" data-bs-parent="#routesAccordion">
            <div class="accordion-body">
                <div class="row g-3">
                    {{-- ================= From Location ================= --}}
                    <div class="form-group col-md-6">
                        {!! Form::label('from_location', 'From Location', ['class' => 'form-label required-input']) !!}
                        {!! Form::text('from_location', null, ['class' => 'form-control ' . ($errors->first('from_location', 'error') ? 'is-invalid' : ''), 'placeholder' => 'e.g., Jeddah Airport', 'required']) !!}
                        {!! $errors->first('from_location', '<label class="error">:message</label>') !!}
                    </div>

                    {{-- ================= To Location ================= --}}
                    <div class="form-group col-md-6">
                        {!! Form::label('to_location', 'To Location', ['class' => 'form-label required-input']) !!}
                        {!! Form::text('to_location', null, ['class' => 'form-control ' . ($errors->first('to_location', 'error') ? 'is-invalid' : ''),'placeholder' => 'e.g., Makkah Hotel', 'required']) !!}
                        {!! $errors->first('to_location', '<label class="error">:message</label>') !!}
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
        });
    </script>
@endpush