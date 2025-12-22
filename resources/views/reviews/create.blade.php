{{-- @extends('layouts.admin')
@section('title', 'Add New Review')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add New Review</h2>
    <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Back to Reviews</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reviews.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="author" class="form-label">Author Name <span class="text-danger">*</span></label>
        <input type="text" name="author" id="author" class="form-control" value="{{ old('author') }}">
    </div>

    <div class="mb-3">
        <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
        <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" placeholder="e.g., Jeddah, Saudi Arabia">
    </div>

    <div class="mb-3">
        <label for="comment" class="form-label">Comment <span class="text-danger">*</span></label>
        <textarea name="comment" id="comment" class="form-control" rows="5">{{ old('comment') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
        <select name="rating" id="rating" class="form-control">
            <option value="">-- Select Rating --</option>
            <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 Stars - Excellent</option>
            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars - Very Good</option>
            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars - Good</option>
            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Stars - Fair</option>
            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Star - Poor</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="booking_reference" class="form-label">Booking Reference (Optional)</label>
        <input type="text" name="booking_reference" id="booking_reference" class="form-control" value="{{ old('booking_reference') }}" placeholder="e.g., BSL-2025-0481">
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">Save Review</button>
        <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection --}}
<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">

                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="Create Review" />
                    <!-- [ breadcrumb ] end -->

                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::open(['route' => 'reviews.store', 'id' => 'formValidation', 'files' => true, 'method'=>'POST','enctype' => 'multipart/form-data']) !!}
                                        <div class="card-body row">
                                            @include('reviews.form')
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