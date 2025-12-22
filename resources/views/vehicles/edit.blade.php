@extends('layouts.admin')
@section('title', 'Edit Vehicle')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Vehicle: {{ $vehicle->name }}</h2>
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
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

    <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control only-alphabets"
                                value="{{ old('name', $vehicle->name) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="seats" class="form-label">Seats <span class="text-danger">*</span></label>
                                <input type="number" name="seats" id="seats" class="form-control"
                                    value="{{ old('seats', $vehicle->seats) }}" min="1" max="50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bags" class="form-label">Bags <span class="text-danger">*</span></label>
                                <input type="number" name="bags" id="bags" class="form-control"
                                    value="{{ old('bags', $vehicle->bags) }}" min="0" max="50">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Features (comma-separated)</label>
                            <input type="text" name="features" id="features" class="form-control"
                                value="{{ old('features', implode(', ', (array) $vehicle->features)) }}"
                                placeholder="WiFi, AC, Child Seat">
                            <small class="text-muted">Separate each feature with a comma</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                    id="is_active" {{ old('is_active', $vehicle->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (visible on website)
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">Vehicle Image</div>
                    <div class="card-body text-center">

                        <div class="mb-3">
                            <img id="imagePreview" src="{{ $vehicle->image_url }}" alt="Preview" class="img-fluid rounded"
                                style="max-height: 180px;">
                        </div>

                        <div class="mb-3">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*"
                                onchange="previewImage(event)">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>

                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check-circle"></i> Update Vehicle
                    </button>
                </div>

            </div>
        </div>
    </form>

@endsection
@push('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('imagePreview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
