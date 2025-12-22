@extends('layouts.admin')
@section('title', 'Edit Review')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Review #{{ $review->id }}</h2>
    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Back to Reviews</a>
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

<form action="{{ route('admin.reviews.update', $review) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="author" class="form-label">Author Name <span class="text-danger">*</span></label>
        <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $review->author) }}">
    </div>

    <div class="mb-3">
        <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
        <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $review->location) }}" placeholder="e.g., Makkah, Saudi Arabia">
    </div>

    <div class="mb-3">
        <label for="comment" class="form-label">Comment <span class="text-danger">*</span></label>
        <textarea name="comment" id="comment" class="form-control" rows="5">{{ old('comment', $review->comment) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
        <select name="rating" id="rating" class="form-control">
            <option value="">-- Select Rating --</option>
            <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>5 Stars - Excellent</option>
            <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>4 Stars - Very Good</option>
            <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>3 Stars - Good</option>
            <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>2 Stars - Fair</option>
            <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>1 Star - Poor</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="booking_reference" class="form-label">Booking Reference (Optional)</label>
        <input type="text" name="booking_reference" id="booking_reference" class="form-control" value="{{ old('booking_reference', $review->booking_reference) }}" placeholder="e.g., BSL-2025-0481">
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">Update Review</button>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection