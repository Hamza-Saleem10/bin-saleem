{{-- @extends('layouts.admin')

@section('title', 'Create Booking')

@section('content')
<div class="container-fluid py-4 py-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Professional Card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1 fw-bold text-dark">
                                <i class="fas fa-car-side text-primary me-2"></i>
                                Create New Booking
                            </h3>
                            <p class="text-muted mb-0">Add customer ride details</p>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.bookings.store') }}" method="POST" id="bookingForm" novalidate>
                        @csrf

                        <!-- Customer Name -->
                        <div class="form-floating mb-4">
                            <input type="text" 
                                   name="customer_name" 
                                   id="customer_name"
                                   class="form-control form-control-lg only-alphabets @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name') }}"
                                   placeholder="Muhammad Ahmed">
                            <label for="customer_name">Customer Name <span class="text-danger">*</span></label>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Customer Email -->
                        <div class="form-floating mb-4">
                            <input type="email" 
                                   name="customer_email" 
                                   id="customer_email"
                                   class="form-control form-control-lg @error('customer_email') is-invalid @enderror"
                                   value="{{ old('customer_email') }}"
                                   placeholder="ahmed@gmail.com">
                            <label for="customer_email">Customer Email <span class="text-danger">*</span></label>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contact No. -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Customer Contact No. <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   id="phone" 
                                   name="customer_contact"
                                   class="form-control form-control-lg @error('customer_contact') is-invalid @enderror"
                                   value="{{ old('customer_contact') }}"
                                   placeholder="300 1234567">
                            @error('customer_contact')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vehicle -->
                        <div class="form-floating mb-4">
                            <select name="vehicle_id" 
                                    id="vehicle_id"
                                    class="form-select form-control-lg @error('vehicle_id') is-invalid @enderror">
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}" {{ old('vehicle_id') == $v->id ? 'selected' : '' }}>
                                        {{ $v->name }}
                                        @if(isset($v->model)) - {{ $v->model }} @endif
                                    </option>
                                @endforeach
                            </select>
                            <label for="vehicle_id">Vehicle <span class="text-danger">*</span></label>
                            @error('vehicle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pickup Location -->
                        <div class="form-floating mb-4">
                            <input type="text" 
                                   name="pickup" 
                                   id="pickup"
                                   class="form-control form-control-lg @error('pickup') is-invalid @enderror"
                                   value="{{ old('pickup') }}"
                                   placeholder="Jeddah Airport">
                            <label for="pickup">Pickup Location <span class="text-danger">*</span></label>
                            @error('pickup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dropoff Location -->
                        <div class="form-floating mb-4">
                            <input type="text" 
                                   name="dropoff" 
                                   id="dropoff"
                                   class="form-control form-control-lg @error('dropoff') is-invalid @enderror"
                                   value="{{ old('dropoff') }}"
                                   placeholder="Makkah Hotel">
                            <label for="dropoff">Dropoff Location <span class="text-danger">*</span></label>
                            @error('dropoff')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-5">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="row g-3">
                                @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                    <div class="col-6 col-md-3">
                                        <div class="form-check">
                                            <input class="btn-check" 
                                                   type="radio" 
                                                   name="status" 
                                                   id="status_{{ $status }}" 
                                                   value="{{ $status }}"
                                                   {{ old('status', 'pending') === $status ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary rounded-pill px-4" 
                                                   for="status_{{ $status }}">
                                                {{ ucfirst($status) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end">
                            <button type="submit" 
                                    class="btn btn-success btn-lg px-5 d-flex align-items-center gap-2"
                                    id="saveBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                Save Booking
                            </button>
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="btn btn-secondary btn-lg px-5">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.3/css/intlTelInput.css" />
<style>
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #0d6efd;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .iti { width: 100%; }
    .iti__flag-container { z-index: 5; }
    .only-alphabets {
        text-transform: capitalize;
    }
    .btn-check:checked + .btn {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.3/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.querySelector("#phone");
        const form = document.querySelector("#bookingForm");
        const saveBtn = document.querySelector("#saveBtn");
        const spinner = saveBtn.querySelector('.spinner-border');

        // Initialize intl-tel-input
        const intl = window.intlTelInput(phoneInput, {
            initialCountry: "pk",
            separateDialCode: true,
            preferredCountries: ["pk", "sa", "ae", "gb"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.3/js/utils.js"
        });

        // Name: Alphabets only
        document.querySelector('.only-alphabets').addEventListener('input', function () {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });

        // Form Submit
        form.addEventListener('submit', function (e) {
            if (!intl.isValidNumber()) {
                e.preventDefault();
                phoneInput.classList.add('is-invalid');
                phoneInput.focus();
                return;
            }

            // Set full number
            phoneInput.value = intl.getNumber();

            // Show loading
            spinner.classList.remove('d-none');
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';
        });

        // Auto-focus first field
        document.getElementById('customer_name').focus();
    });
</script>
@endpush --}}
<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Create Bookings" />
                    <!-- [ breadcrumb ] end -->

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::open(['route' => 'bookings.store', 'id' => 'formValidation', 'files' => true, 'method'=>'POST','enctype' => 'multipart/form-data']) !!}
                                        <div class="card-body row">
                                            @include('bookings.form')
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <button type="button" onclick="window.location='{{ URL::previous() }}'"
                                                class="btn btn-secondary">Cancel</button>
                                        </div>
                                        {!! Form::close() !!}
                                        <!--end::Form-->
                                    </div>
                                </div>
                                <!-- [ basic-table ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

</x-app-layout>
